<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\WickedOMeter;
use App\Models\ProductionTeam;
use App\Models\ItemOptions;
use App\Models\ProductCategories;
use App\Models\UnitOfMeasures;
use App\Models\Departments;
use App\Models\ItemCategories;
use App\Models\Locations;
use App\Models\CostingMethod;
use App\Models\Countries;
use App\Models\Styles;
use App\Models\Fabric;
use App\Models\Colour;
use App\Models\TopSizes;
use App\Models\Sizes;
use App\Models\BackVariations;
use App\Models\StyleVariations;
use App\Models\Prints;
use App\Models\TrouserLength;
use App\Models\CostEstimateType;
use App\Models\WeightUnits;
use App\Models\Currencies;
use App\Models\ItemSource;
use App\Models\Bins;
use App\Models\ProductModel;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AssemblyController extends Controller
{
    public function index()
    {
        $items = ProductModel::getItems();

        return view('products.assembly', compact(['items']));
    }

    public function new()
    {
        $wicked_o_meter = WickedOMeter::where('status', 'Active')->orderBy('idx')->get();
        $production_team = ProductionTeam::where('status', 'Active')->orderBy('idx')->get();
        $item_options = ItemOptions::where('status', 'Active')->orderBy('idx')->get();
        $product_categories = ProductCategories::where('status', 'Active')->orderBy('idx')->get();
        $unit_of_measures = UnitOfMeasures::where([['base_unit', '1'],['status', 'Active']])->orderBy('idx')->get();
        $departments = Departments::where('status', 'Active')->orderBy('idx')->get();
        $item_categories = ItemCategories::where('status', 'Active')->orderBy('idx')->get();
        $locations = Locations::where('status', 'Active')->orderBy('idx')->get();
        $costing_method = CostingMethod::where('status', 'Active')->orderBy('idx')->get();
        $countries = Countries::where('status', 'Active')->orderBy('idx')->get();
        $styles = Styles::where('status', 'Active')->orderBy('idx')->get();
        $fabric = Fabric::where('status', 'Active')->orderBy('idx')->get();
        $colour = Colour::where('status', 'Active')->orderBy('idx')->get();
        $top_sizes = TopSizes::where('status', 'Active')->orderBy('idx')->get();
        $sizes = Sizes::where('status', 'Active')->orderBy('idx')->get();
        $back_variations = BackVariations::where('status', 'Active')->orderBy('idx')->get();
        $style_variations = StyleVariations::where('status', 'Active')->orderBy('idx')->get();
        $prints = Prints::where('status', 'Active')->orderBy('idx')->get();
        $trouser_length = TrouserLength::where('status', 'Active')->orderBy('idx')->get();
        $cost_estimate_type = CostEstimateType::where('status', 'Active')->orderBy('idx')->get();
        $weight_units = WeightUnits::where('status', 'Active')->orderBy('idx')->get();
        $currencies = Currencies::where('status', 'Active')->orderBy('name')->get();
        $tax_codes = ProductModel::getTaxCode();

        return view('products.assembly_new', compact([
            'wicked_o_meter', 
            'production_team', 
            'item_options',
            'product_categories',
            'unit_of_measures', 
            'departments', 
            'item_categories',
            'locations', 
            'costing_method',
            'countries', 
            'styles', 
            'fabric',
            'colour',
            'top_sizes',
            'sizes',
            'back_variations',
            'style_variations',
            'prints',
            'trouser_length',
            'cost_estimate_type', 
            'weight_units', 
            'currencies',
            'tax_codes'
        ]));
    }

    public function getSubUnitOfMeasures(Request $request){
        $subUnit = ProductModel::getUnitOfMeasuresByUnitTypeID($request->unitTypeID);

        return $subUnit;
    }

    public function setNewBOM(){
        $item_source = ItemSource::where('status', 'active')->orderBy('idx')->get();
        
        return view('products.assembly_new_bom_new', compact(['item_source']));
    }

    public function searchItemByName(Request $request){
        $items = ProductModel::getItemsByName($request);

        return response()->json($items);
    }

    public function setEditBOM(Request $request){
        $item_source = ItemSource::where('status', 'active')->orderBy('idx')->get();
        
        $dt = [
            $request->itemID, 
            $request->unitTypeID, 
            $request->taxCodeID, 
            $request->itemSourceID,
            $request->itemName,
            $request->itemDescription,
            $request->quantity,
            $request->unit,
            $request->taxCode,
            $request->taxRate,
            $request->effectiveDate,
            $request->obseleteDate
        ];

        return view('products.assembly_new_bom_edit', compact(['item_source', 'dt']));
    }

    public function setNewBIN(){
        $locations = Locations::where('status', 'active')->orderBy('idx')->get();

        return view('products.assembly_new_bin_new', compact(['locations']));
    }

    public function getBinsByLocationID(Request $request){
        $bins = Bins::where('location_id', $request->locationID)->orderBy('idx')->get();

        return $bins;
    }

    public function setEditBIN(Request $request){
        $locations = Locations::where('status', 'active')->orderBy('idx')->get();
        $bins = Bins::where('location_id', $request->locationID)->orderBy('idx')->get();

        $dt = [
            $request->locationID, 
            $request->binID, 
            $request->locationActive, 
            $request->preferredLocation
        ];

        return view('products.assembly_new_bin_edit', compact(['locations', 'bins', 'dt']));
    }

    public function createItem(Request $request){
        $data = ProductModel::createItem($request);
        
        echo json_encode($data);
    }

    public function view($id){
        $items = ProductModel::getItemsByItemID($id);
        $inventory_items = ProductModel::getInventoryItemsByItemID($id);
        $bom = ProductModel::getBOMItemsByItemID($id);
        $bins = ProductModel::getBinItemsByItemID($id);
        $price_levels = ProductModel::getPriceLevelsByItemID($id);

        return view('products.assembly_view', compact(['id', 'items', 'inventory_items', 'bom', 'bins', 'price_levels']));
    }

    public function edit($id){
        $wicked_o_meter = WickedOMeter::where('status', 'Active')->orderBy('idx')->get();
        $production_team = ProductionTeam::where('status', 'Active')->orderBy('idx')->get();
        $item_options = ItemOptions::where('status', 'Active')->orderBy('idx')->get();
        $product_categories = ProductCategories::where('status', 'Active')->orderBy('idx')->get();
        $unit_of_measures = UnitOfMeasures::where([['base_unit', '1'],['status', 'Active']])->orderBy('idx')->get();
        $departments = Departments::where('status', 'Active')->orderBy('idx')->get();
        $item_categories = ItemCategories::where('status', 'Active')->orderBy('idx')->get();
        $locations = Locations::where('status', 'Active')->orderBy('idx')->get();
        $costing_method = CostingMethod::where('status', 'Active')->orderBy('idx')->get();
        $countries = Countries::where('status', 'Active')->orderBy('idx')->get();
        $styles = Styles::where('status', 'Active')->orderBy('idx')->get();
        $fabric = Fabric::where('status', 'Active')->orderBy('idx')->get();
        $colour = Colour::where('status', 'Active')->orderBy('idx')->get();
        $top_sizes = TopSizes::where('status', 'Active')->orderBy('idx')->get();
        $sizes = Sizes::where('status', 'Active')->orderBy('idx')->get();
        $back_variations = BackVariations::where('status', 'Active')->orderBy('idx')->get();
        $style_variations = StyleVariations::where('status', 'Active')->orderBy('idx')->get();
        $prints = Prints::where('status', 'Active')->orderBy('idx')->get();
        $trouser_length = TrouserLength::where('status', 'Active')->orderBy('idx')->get();
        $cost_estimate_type = CostEstimateType::where('status', 'Active')->orderBy('idx')->get();
        $weight_units = WeightUnits::where('status', 'Active')->orderBy('idx')->get();
        $currencies = Currencies::where('status', 'Active')->orderBy('name')->get();
        $tax_codes = ProductModel::getTaxCode();

        $items = ProductModel::getItemsByItemID($id);
        $inventory_items = ProductModel::getInventoryItemsByItemID($id);
        $bom = ProductModel::getBOMItemsByItemID($id);
        $bins = ProductModel::getBinItemsByItemID($id);
        $price_levels = ProductModel::getPriceLevelsByItemID($id);

        $subunit_of_measures = ProductModel::getUnitOfMeasuresByUnitTypeID($items->unit_type);

        return view('products.assembly_edit', compact([
            'id',
            'wicked_o_meter', 
            'production_team', 
            'item_options',
            'product_categories',
            'unit_of_measures', 
            'subunit_of_measures',
            'departments', 
            'item_categories',
            'locations', 
            'costing_method',
            'countries', 
            'styles', 
            'fabric',
            'colour',
            'top_sizes',
            'sizes',
            'back_variations',
            'style_variations',
            'prints',
            'trouser_length',
            'cost_estimate_type', 
            'weight_units', 
            'currencies',
            'tax_codes',
            'items',
            'inventory_items',
            'bom',
            'bins',
            'price_levels'
        ]));
    }

    public function updateItem(Request $request){
        $data['success'] = ProductModel::updateItem($request);
        
        echo json_encode($data);
    }
}

