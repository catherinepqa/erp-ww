<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BackVariations;
use App\Bins;
use App\Colour;
use App\Countries;
use App\Currencies;
use App\Departments;
use App\ExchangeRates;
use App\Fabric;
use App\ItemCategories;
use App\ItemOptions;
use App\ItemTypes;
use App\Locations;
use App\Prints;
use App\ProductCategories;
use App\ProductionTeam;
use App\ShippingCarrier;
use App\Sizes;
use App\Styles;
use App\StyleVariations;
use App\TaxCodes;
use App\TaxTypes;
use App\TopSizes;
use App\TrouserLength;
use App\UnitOfMeasures;
use App\WeightUnits;
use App\WickedoMeter;
use DB;
use Redirect;

class SetupController extends Controller
{
    //-- 2.13.2 --> DEPARTMENTS --//
    public function departments()
    {
        $departments = Departments::where('status', 'active')->orderBy('idx')->get();
        foreach ($departments as $dept) {
            $subdepartment = Departments::where('department_id', $dept->subdepartment_id)->get();
            $dept['subdepartments'] = $subdepartment;
        }

        return view('setup.department.departments', compact('departments', 'subdepartment'));
    }

    public function edit_department($id)
    {
        $department = Departments::findOrFail($id);
        $departments = Departments::all('name');
        return view('setup.department.edit_department', compact('department', 'departments'));
    }

    public function new_department()
    {
        $departments = Departments::all('name');
        return view('setup.department.new_department', compact('departments'));
    }

    public function store_department(Request $request)
    {
        $request->validate([
            'name'              => 'required|unique:departments',
            'abbreviation'      => 'nullable|max:10||unique:departments',
            'subdepartment_id'  => 'nullable',
            'idx'               => 'required|numeric',
        ]);

        $save = Departments::store_department($request);

        if ($save !== false) {
                return redirect('/department/departments')->with('success', 'success')->with('message', 'Successfully created new department!');
        } else {
            return Redirect::back()->withErrors('Failed to create department. Please try again.')->withInput();
        }
    }

    public function update_department(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required|unique:departments,name,'.$id.',department_id',
            'abbreviation'      => 'nullable|max:10||unique:departments,abbreviation,'.$id.',department_id',
            'subdepartment_id'  => 'nullable',
            'idx'               => 'required|numeric',
        ]);

        $update  = Departments::update_department($request, $id);

        if ($update !== false) {
            return redirect('/department/departments')->with('success', 'success')->with('message', 'Successfully updated department!');
        } else {
            return Redirect::back()->withErrors('Failed to update department. Please try again.')->withInput();
        }
    }

    public function view_department(Request $request, $id)
    {
        $department = Departments::findOrFail($id);
        $departments = DB::table('departments as a')
            ->join('departments as b', 'a.subdepartment_id', '=', 'b.department_id')
            ->where('a.department_id', $id)
            ->select('a.name as aname', 'b.name as bname')
            ->get();
        return view('setup.department.view_department', compact('department', 'departments'));
    }

    //-- END OF DEPARTMENTS --//

    //-- 2.13.2 --> LOCATIONS --//

    public function locations()
    {
        $locations = Locations::with('Countries:name')->get();
        // dd($locations);

        foreach ($locations as $location) {
            $sublocation = Locations::where('location_id', $location->sublocation_id)->get();
            $location['sublocations'] = $sublocation;
        }
        return view('setup.location.locations', compact('locations', 'sublocation'));
    }

    public function edit_location($id)
    {
        $location  = Locations::findOrFail($id);
        $countries = Countries::all('name');
        $locations = Locations::all('name');
        return view('setup.location.edit_location', compact('location', 'countries', 'locations'));
    }

    public function new_location()
    {
        $countries = Countries::all('name');
        $locations = Locations::all('name');
        return view('setup.location.new_location', compact('countries', 'locations'));
    }

    public function store_location(Request $request)
    {
        $request->validate([
            'name'              => 'required|unique:locations',
            'abbreviation'      => 'nullable|max:10||unique:locations',
            'sublocation_id'    => 'nullable',
            'city'              => 'nullable',
            'zip_code'          => 'nullable',
            'address_1'         => 'nullable',
            'address_2'         => 'nullable',
            'phone_no'          => 'nullable|numeric',
            'use_bins'          => 'nullable',
            'idx'               => 'nullable|numeric',
        ]);

        $save = Locations::store_location($request);

        if ($save !== false) {
                return redirect('/location/locations')->with('success', 'success')->with('message', 'Successfully created new location!');
        } else {
            return Redirect::back()->withErrors('Failed to create location. Please try again.')->withInput();
        }
    }

    public function update_location(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required|unique:locations,name,'.$id.',location_id',
            'abbreviation'      => 'nullable|max:10||unique:locations,abbreviation,'.$id.',location_id',
            'sublocation_id'    => 'nullable',
            'city'              => 'nullable',
            'zip_code'          => 'nullable',
            'address_1'         => 'nullable',
            'address_2'         => 'nullable',
            'phone_no'          => 'nullable|numeric',
            'use_bins'          => 'nullable',
            'idx'               => 'nullable|numeric',
        ]);

        $update  = Locations::update_location($request, $id);

        if ($update !== false) {
            return redirect('/location/locations')->with('success', 'success')->with('message', 'Successfully updated location!');
        } else {
            return Redirect::back()->withErrors('Failed to update location. Please try again.')->withInput();
        }
    }

    public function view_location(Request $request, $id)
    {
        $location = Locations::findOrFail($id);
        $locations = DB::table('locations as a')
            ->join('locations as b', 'a.sublocation_id', '=', 'b.location_id')
            ->where('a.location_id', $id)
            ->select('a.name as aname', 'b.name as bname')
            ->get();
        $countries = Countries::all('name');
        return view('setup.location.view_location', compact('location', 'locations', 'countries'));
    }

    //-- END OF LOCATIONS --//

    //-- 2.13.2 --> PRODUCTION TEAM --//

    public function production_team()
    {
        $prodTeams = ProductionTeam::where('status', 'active')->orderBy('idx')->get();
        return view('setup.production_team.index', compact('prodTeams'));
    }

    public function edit_productionTeam($id)
    {
        $prodTeam = ProductionTeam::findOrFail($id);
        return view('setup.production_team.edit', compact('prodTeam'));
    }

    public function new_productionTeam()
    {
        return view('setup.production_team.new');
    }

    public function store_productionTeam(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:production_team',
            'abbreviation'  => 'nullable|unique:production_team',
            'idx'           => 'required|numeric',
        ]);

        $save = ProductionTeam::store_productionTeam($request);

        if ($save !== false) {
                return redirect('/production_team/index')->with('success', 'success')->with('message', 'Successfully created new production team!');
        } else {
            return Redirect::back()->withErrors('Failed to create production_team. Please try again.')->withInput();
        }
    }

    public function update_productionTeam(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:production_team,name,'.$id.',production_team_id',
            'abbreviation'  => 'nullable|unique:production_team,abbreviation,'.$id.',production_team_id',
            'idx'           => 'required|numeric',
        ]);

        $update  = ProductionTeam::update_productionTeam($request, $id);

        if ($update !== false) {
            return redirect('/production_team/index')->with('success', 'success')->with('message', 'Successfully updated production team!');
        } else {
            return Redirect::back()->withErrors('Failed to update production_team. Please try again.')->withInput();
        }
    }

    public function view_productionTeam(Request $request, $id)
    {
        $prodTeam = ProductionTeam::findOrFail($id);
        return view('setup.production_team.view', compact('prodTeam'));
    }

    //-- END OF PRODUCTION TEAM --//

    //-- 2.13.3 --> PRODUCT CATEGORIES --//

    public function product_categories()
    {
        $productCategories = ProductCategories::where('status', 'active')->orderBy('idx')->get();
        return view('setup.product_categories.index', compact('productCategories'));
    }

    public function edit_productCategories($id)
    {
        $productCategory = ProductCategories::findOrFail($id);
        return view('setup.product_categories.edit', compact('productCategory'));
    }

    public function new_productCategory()
    {
        return view('setup.product_categories.new');
    }

    public function store_productCategory(Request $request)
    {
        $request->validate([
            'name'  => 'required|unique:product_categories',
            'idx'   => 'required|numeric',
        ]);

        $save = ProductCategories::store_productCategory($request);

        if ($save !== false) {
                return redirect('/product_categories/index')->with('success', 'success')->with('message', 'Successfully created new product category!');
        } else {
            return Redirect::back()->withErrors('Failed to create product category. Please try again.')->withInput();
        }
    }

    public function update_prouductCategory(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|unique:product_categories,name,'.$id.',product_category_id',
            'idx'   => 'required|numeric',
        ]);

        $update  = ProductCategories::update_prouductCategory($request, $id);

        if ($update !== false) {
            return redirect('/product_categories/index')->with('success', 'success')->with('message', 'Successfully updated product category!');
        } else {
            return Redirect::back()->withErrors('Failed to update product category. Please try again.')->withInput();
        }
    }

    public function view_productCategory(Request $request, $id)
    {
        $productCategory = ProductCategories::findOrFail($id);
        return view('setup.product_categories.view', compact('productCategory'));
    }

    //-- END OF PRODUCT CATEGORIES --//

    //-- 2.13.3 --> ITEM CATEGORIES --//

    public function item_categories()
    {
        $itemCategories = ItemCategories::where('status', 'active')->orderBy('idx')->get();
        foreach ($itemCategories as $itemCategory) {
            $subitem_category = ItemCategories::where('item_category_id', $itemCategory->subitem_category_id)->get();
            $itemCategory['subitemcategories'] = $subitem_category;
        }
        return view('setup.item_categories.index', compact('itemCategories'));
    }

    public function edit_itemCategory($id)
    {
        $itemCategory = ItemCategories::findOrFail($id);
        $itemCategories = ItemCategories::all('name');
        return view('setup.item_categories.edit', compact('itemCategory', 'itemCategories'));
    }

    public function new_itemCategory()
    {
        $itemCategories = ItemCategories::all('name');
        return view('setup.item_categories.new', compact('itemCategories'));
    }

    public function store_itemCategory(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:item_categories',
            'abbreviation'  => 'nullable|unique:item_categories',
            'idx'           => 'required|numeric',
        ]);
        $save = ItemCategories::store_itemCategory($request);

        if ($save !== false) {
                return redirect('/item_categories/index')->with('success', 'success')->with('message', 'Successfully created new item category!');
        } else {
            return Redirect::back()->withErrors('Failed to create item category. Please try again.')->withInput();
        }
    }

    public function update_itemCategory(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:item_categories,name,'.$id.',item_category_id',
            'abbreviation'  => 'nullable|unique:item_categories,abbreviation,'.$id.',item_category_id',
            'idx'           => 'required|numeric',
        ]);

        $update  = ItemCategories::update_itemCategory($request, $id);

        if ($update !== false) {
            return redirect('/item_categories/index')->with('success', 'success')->with('message', 'Successfully updated item category!');
        } else {
            return Redirect::back()->withErrors('Failed to update item category. Please try again.')->withInput();
        }
    }

    public function view_itemCategory(Request $request, $id)
    {
        $itemCategory = ItemCategories::findOrFail($id);
        $itemCategories = DB::table('item_categories as a')
            ->join('item_categories as b', 'a.subitem_category_id', '=', 'b.item_category_id')
            ->where('a.item_category_id', $id)
            ->select('a.name as aname', 'b.name as bname')
            ->get();
        return view('setup.item_categories.view', compact('itemCategory', 'itemCategories'));
    }

    //-- END OF ITEM CATEGORIES --//

    //-- 2.13.3 --> ITEM TYPES --//

    public function item_types()
    {
        $itemTypes = ItemTypes::where('status', 'active')->orderBy('idx')->get();
        return view('setup.item_types.index', compact('itemTypes'));
    }

    public function edit_itemType($id)
    {
        $itemType = ItemTypes::findOrFail($id);
        return view('setup.item_types.edit', compact('itemType'));
    }

    public function new_itemType()
    {
        return view('setup.item_types.new');
    }

    public function store_itemType(Request $request)
    {
        $request->validate([
            'name'  => 'required|unique:item_types',
            'idx'   => 'required|numeric',
        ]);
        $save = ItemTypes::store_itemType($request);

        if ($save !== false) {
                return redirect('/item_types/index')->with('success', 'success')->with('message', 'Successfully created new item type!');
        } else {
            return Redirect::back()->withErrors('Failed to create item type. Please try again.')->withInput();
        }
    }

    public function update_itemType(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|unique:item_types,name,'.$id.',item_type_id',
            'idx'   => 'required|numeric',
        ]);
        $update  = ItemTypes::update_itemType($request, $id);

        if ($update !== false) {
            return redirect('/item_types/index')->with('success', 'success')->with('message', 'Successfully updated item type!');
        } else {
            return Redirect::back()->withErrors('Failed to update item type. Please try again.')->withInput();
        }
    }

    public function view_itemType(Request $request, $id)
    {
        $itemType = ItemTypes::findOrFail($id);
        return view('setup.item_types.view', compact('itemType'));
    }

    //-- END OF ITEM TYPE --//

    //-- 2.13.4 --> STYLES --//

    public function styles()
    {
        $styles = Styles::where('status', 'active')->orderBy('idx')->get();
        return view('setup.styles.index', compact('styles'));
    }

    public function edit_style($id)
    {
        $style = Styles::findOrFail($id);
        return view('setup.styles.edit', compact('style'));
    }

    public function new_style()
    {
        return view('setup.styles.new');
    }

    public function store_style(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:styles',
            'abbreviation'  => 'nullable|unique:styles',
            'idx'           => 'required|numeric',
        ]);
        $save = Styles::store_style($request);

        if ($save !== false) {
                return redirect('/styles/index')->with('success', 'success')->with('message', 'Successfully created new style!');
        } else {
            return Redirect::back()->withErrors('Failed to create style. Please try again.')->withInput();
        }
    }

    public function update_style(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:styles,name,'.$id.',style_id',
            'abbreviation'  => 'nullable|unique:styles,abbreviation,'.$id.',style_id',
            'idx'           => 'required|numeric',
        ]);
        $update  = Styles::update_style($request, $id);

        if ($update !== false) {
            return redirect('/styles/index')->with('success', 'success')->with('message', 'Successfully updated style!');
        } else {
            return Redirect::back()->withErrors('Failed to update style. Please try again.')->withInput();
        }
    }

    public function view_style(Request $request, $id)
    {
        $style = Styles::findOrFail($id);
        return view('setup.styles.view', compact('style'));
    }

    //-- END OF STYLES --//

    //-- 2.13.4 --> FABRIC --//

    public function fabric()
    {
        $fabrics = Fabric::where('status', 'active')->orderBy('idx')->get();
        return view('setup.fabric.index', compact('fabrics'));
    }

    public function edit_fabric($id)
    {
        $fabric = Fabric::findOrFail($id);
        return view('setup.fabric.edit', compact('fabric'));
    }

    public function new_fabric()
    {
        return view('setup.fabric.new');
    }

    public function store_fabric(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:fabric',
            'abbreviation'  => 'nullable|unique:fabric',
            'idx'           => 'required|numeric',
        ]);
        $save = Fabric::store_fabric($request);

        if ($save !== false) {
                return redirect('/fabric/index')->with('success', 'success')->with('message', 'Successfully created new fabric!');
        } else {
            return Redirect::back()->withErrors('Failed to create fabric. Please try again.')->withInput();
        }
    }

    public function update_fabric(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:fabric,name,'.$id.',fabric_id',
            'abbreviation'  => 'nullable|unique:fabric,abbreviation,'.$id.',fabric_id',
            'idx'           => 'required|numeric',
        ]);
        $update  = Fabric::update_fabric($request, $id);

        if ($update !== false) {
            return redirect('/fabric/index')->with('success', 'success')->with('message', 'Successfully updated fabric!');
        } else {
            return Redirect::back()->withErrors('Failed to update fabric. Please try again.')->withInput();
        }
    }

    public function view_fabric(Request $request, $id)
    {
        $fabric = Fabric::findOrFail($id);
        return view('setup.fabric.view', compact('fabric'));
    }

    //-- END OF FABRIC --//

    //-- 2.13.4 --> COLOUR --//

    public function colour()
    {
        $colours = Colour::where('status', 'active')->orderBy('idx')->get();
        return view('setup.colour.index', compact('colours'));
    }

    public function edit_colour($id)
    {
        $colour = Colour::findOrFail($id);
        return view('setup.colour.edit', compact('colour'));
    }

    public function new_colour()
    {
        return view('setup.colour.new');
    }

    public function store_colour(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:colour',
            'abbreviation'  => 'nullable|unique:colour',
            'idx'           => 'required|numeric',
        ]);
        $save = Colour::store_colour($request);

        if ($save !== false) {
                return redirect('/colour/index')->with('success', 'success')->with('message', 'Successfully created new colour!');
        } else {
            return Redirect::back()->withErrors('Failed to create colour. Please try again.')->withInput();
        }
    }

    public function update_colour(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:colour,name,'.$id.',colour_id',
            'abbreviation'  => 'nullable|unique:colour,abbreviation,'.$id.',colour_id',
            'idx'           => 'required|numeric',
        ]);
        $update  = Colour::update_colour($request, $id);

        if ($update !== false) {
            return redirect('/colour/index')->with('success', 'success')->with('message', 'Successfully updated colour!');
        } else {
            return Redirect::back()->withErrors('Failed to update colour. Please try again.')->withInput();
        }
    }

    public function view_colour(Request $request, $id)
    {
        $colour = Colour::findOrFail($id);
        return view('setup.colour.view', compact('colour'));
    }

    //-- END OF COLOUR --//

    //-- 2.13.4 --> TYPE SIZES --//

    public function top_sizes()
    {
        $topSizes = TopSizes::where('status', 'active')->orderBy('idx')->get();
        return view('setup.top_sizes.index', compact('topSizes'));
    }

    public function edit_topSize($id)
    {
        $topSize = TopSizes::findOrFail($id);
        return view('setup.top_sizes.edit', compact('topSize'));
    }

    public function new_topSize()
    {
        return view('setup.top_sizes.new');
    }

    public function store_topSize(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:top_sizes',
            'abbreviation'  => 'nullable|unique:top_sizes',
            'idx'           => 'required|numeric',
        ]);
        $save = TopSizes::store_topSize($request);

        if ($save !== false) {
                return redirect('/top_sizes/index')->with('success', 'success')->with('message', 'Successfully created new top size!');
        } else {
            return Redirect::back()->withErrors('Failed to create top size. Please try again.')->withInput();
        }
    }

    public function update_topSize(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:top_sizes,name,'.$id.',top_size_id',
            'abbreviation'  => 'nullable|unique:top_sizes,abbreviation,'.$id.',top_size_id',
            'idx'           => 'required|numeric',
        ]);
        $update  = TopSizes::update_topSize($request, $id);

        if ($update !== false) {
            return redirect('/top_sizes/index')->with('success', 'success')->with('message', 'Successfully updated top size!');
        } else {
            return Redirect::back()->withErrors('Failed to update top size. Please try again.')->withInput();
        }
    }

    public function view_topSize(Request $request, $id)
    {
        $topSize = TopSizes::findOrFail($id);
        return view('setup.top_sizes.view', compact('topSize'));
    }

    //-- END OF TOP SIZES --//

    //-- 2.13.4 --> SIZES --//

    public function sizes()
    {
        $sizes = Sizes::where('status', 'active')->orderBy('idx')->get();
        return view('setup.sizes.index', compact('sizes'));
    }

    public function edit_size($id)
    {
        $size = Sizes::findOrFail($id);
        return view('setup.sizes.edit', compact('size'));
    }

    public function new_size()
    {
        return view('setup.sizes.new');
    }

    public function store_size(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:sizes',
            'abbreviation'  => 'nullable|unique:sizes',
            'idx'           => 'required|numeric',
        ]);
        $save = Sizes::store_size($request);

        if ($save !== false) {
                return redirect('/sizes/index')->with('success', 'success')->with('message', 'Successfully created new size!');
        } else {
            return Redirect::back()->withErrors('Failed to create size. Please try again.')->withInput();
        }
    }

    public function update_size(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:sizes,name,'.$id.',size_id',
            'abbreviation'  => 'nullable|unique:sizes,abbreviation,'.$id.',size_id',
            'idx'           => 'required|numeric',
        ]);
        $update  = Sizes::update_size($request, $id);

        if ($update !== false) {
            return redirect('/sizes/index')->with('success', 'success')->with('message', 'Successfully updated size!');
        } else {
            return Redirect::back()->withErrors('Failed to update size. Please try again.')->withInput();
        }
    }

    public function view_size(Request $request, $id)
    {
        $size = Sizes::findOrFail($id);
        return view('setup.sizes.view', compact('size'));
    }

    //-- END OF SIZES --//

    //-- 2.13.4 --> BACK VARIATIONS --//

    public function back_variations()
    {
        $backVariations = BackVariations::where('status', 'active')->orderBy('idx')->get();
        return view('setup.back_variations.index', compact('backVariations'));
    }

    public function edit_backVariation($id)
    {
        $backVariation = BackVariations::findOrFail($id);
        return view('setup.back_variations.edit', compact('backVariation'));
    }

    public function new_backVariation()
    {
        return view('setup.back_variations.new');
    }

    public function store_backVariation(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:back_variations',
            'abbreviation'  => 'nullable|unique:back_variations',
            'idx'           => 'required|numeric',
        ]);
        $save = BackVariations::store_backVariation($request);

        if ($save !== false) {
                return redirect('/back_variations/index')->with('success', 'success')->with('message', 'Successfully created new back variation!');
        } else {
            return Redirect::back()->withErrors('Failed to create back variation. Please try again.')->withInput();
        }
    }

    public function update_backVariation(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:back_variations,name,'.$id.',back_variation_id',
            'abbreviation'  => 'nullable|unique:back_variations,abbreviation,'.$id.',back_variation_id',
            'idx'           => 'required|numeric',
        ]);
        $update  = BackVariations::update_backVariation($request, $id);

        if ($update !== false) {
            return redirect('/back_variations/index')->with('success', 'success')->with('message', 'Successfully updated back variation!');
        } else {
            return Redirect::back()->withErrors('Failed to update back variation. Please try again.')->withInput();
        }
    }

    public function view_backVariation(Request $request, $id)
    {
        $backVariation = BackVariations::findOrFail($id);
        return view('setup.back_variations.view', compact('backVariation'));
    }

    //-- END OF BACK VARIATIONS --//

    //-- 2.13.4 --> STYLE VARIATIONS --//

    public function style_variations()
    {
        $styleVariations = StyleVariations::where('status', 'active')->orderBy('idx')->get();
        return view('setup.style_variations.index', compact('styleVariations'));
    }

    public function edit_styleVariation($id)
    {
        $styleVariation = StyleVariations::findOrFail($id);
        return view('setup.style_variations.edit', compact('styleVariation'));
    }

    public function new_styleVariation()
    {
        return view('setup.style_variations.new');
    }

    public function store_styleVariation(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:style_variations',
            'abbreviation'  => 'nullable|unique:style_variations',
            'idx'           => 'required|numeric',
        ]);
        $save = StyleVariations::store_styleVariation($request);

        if ($save !== false) {
                return redirect('/style_variations/index')->with('success', 'success')->with('message', 'Successfully created new style variation!');
        } else {
            return Redirect::back()->withErrors('Failed to create style variation. Please try again.')->withInput();
        }
    }

    public function update_styleVariation(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:style_variations,name,'.$id.',style_variation_id',
            'abbreviation'  => 'nullable|unique:style_variations,abbreviation,'.$id.',style_variation_id',
            'idx'           => 'required|numeric',
        ]);
        $update  = StyleVariations::update_styleVariation($request, $id);

        if ($update !== false) {
            return redirect('/style_variations/index')->with('success', 'success')->with('message', 'Successfully updated style variation!');
        } else {
            return Redirect::back()->withErrors('Failed to update style variation. Please try again.')->withInput();
        }
    }

    public function view_styleVariation(Request $request, $id)
    {
        $styleVariation = StyleVariations::findOrFail($id);
        return view('setup.style_variations.view', compact('styleVariation'));
    }

    //-- END OF STYLE VARIATIONS --//

    //-- 2.13.4 --> PRINTS --//

    public function prints()
    {
        $prints = Prints::where('status', 'active')->orderBy('idx')->get();
        return view('setup.prints.index', compact('prints'));
    }

    public function edit_print($id)
    {
        $print = Prints::findOrFail($id);
        return view('setup.prints.edit', compact('print'));
    }

    public function new_print()
    {
        return view('setup.prints.new');
    }

    public function store_print(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:prints',
            'abbreviation'  => 'nullable|unique:prints',
            'idx'           => 'required|numeric',
        ]);
        $save = Prints::store_print($request);

        if ($save !== false) {
                return redirect('/prints/index')->with('success', 'success')->with('message', 'Successfully created new print!');
        } else {
            return Redirect::back()->withErrors('Failed to create print. Please try again.')->withInput();
        }
    }

    public function update_print(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:prints,name,'.$id.',print_id',
            'abbreviation'  => 'nullable|unique:prints,abbreviation,'.$id.',print_id',
            'idx'           => 'required|numeric',
        ]);
        $update  = Prints::update_print($request, $id);

        if ($update !== false) {
            return redirect('/prints/index')->with('success', 'success')->with('message', 'Successfully updated print!');
        } else {
            return Redirect::back()->withErrors('Failed to update print. Please try again.')->withInput();
        }
    }

    public function view_print(Request $request, $id)
    {
        $print = Prints::findOrFail($id);
        return view('setup.prints.view', compact('print'));
    }

    //-- END OF PRINTS --//

    //-- 2.13.4 --> TROUSER LENGTH --//

    public function trouser_length()
    {
        $trouserLengths = TrouserLength::where('status', 'active')->orderBy('idx')->get();
        return view('setup.trouser_length.index', compact('trouserLengths'));
    }

    public function edit_trouserLength($id)
    {
        $trouserLength = TrouserLength::findOrFail($id);
        return view('setup.trouser_length.edit', compact('trouserLength'));
    }

    public function new_trouserLength()
    {
        return view('setup.trouser_length.new');
    }

    public function store_trouserLength(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:trouser_length',
            'abbreviation'  => 'nullable|unique:trouser_length',
            'idx'           => 'required|numeric',
        ]);
        $save = TrouserLength::store_trouserLength($request);

        if ($save !== false) {
                return redirect('/trouser_length/index')->with('success', 'success')->with('message', 'Successfully created new trouser length!');
        } else {
            return Redirect::back()->withErrors('Failed to create trouser length. Please try again.')->withInput();
        }
    }

    public function update_trouserLength(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:trouser_length,name,'.$id.',trouser_length_id',
            'abbreviation'  => 'nullable|unique:trouser_length,abbreviation,'.$id.',trouser_length_id',
            'idx'           => 'required|numeric',
        ]);
        $update  = TrouserLength::update_trouserLength($request, $id);

        if ($update !== false) {
            return redirect('/trouser_length/index')->with('success', 'success')->with('message', 'Successfully updated trouser length!');
        } else {
            return Redirect::back()->withErrors('Failed to update trouser length. Please try again.')->withInput();
        }
    }

    public function view_trouserLength(Request $request, $id)
    {
        $trouserLength = TrouserLength::findOrFail($id);
        return view('setup.trouser_length.view', compact('trouserLength'));
    }

    //-- END OF TROUSER LENGTH --//

    //-- 2.13.4 --> ITEM OPTIONS --//

    public function item_options()
    {
        $itemOptions = ItemOptions::where('status', 'active')->orderBy('idx')->get();
        return view('setup.item_options.index', compact('itemOptions'));
    }

    public function edit_itemOption($id)
    {
        $itemOption = ItemOptions::findOrFail($id);
        return view('setup.item_options.edit', compact('itemOption'));
    }

    public function new_itemOption()
    {
        return view('setup.item_options.new');
    }

    public function store_itemOption(Request $request)
    {
        $request->validate([
            'name'  => 'required|unique:item_options',
            'idx'   => 'required|numeric',
        ]);
        $save = ItemOptions::store_itemOption($request);

        if ($save !== false) {
                return redirect('/item_options/index')->with('success', 'success')->with('message', 'Successfully created new item option!');
        } else {
            return Redirect::back()->withErrors('Failed to create item option. Please try again.')->withInput();
        }
    }

    public function update_itemOption(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|unique:item_options,name,'.$id.',item_option_id',
            'idx'   => 'required|numeric',
        ]);
        $update  = ItemOptions::update_itemOption($request, $id);

        if ($update !== false) {
            return redirect('/item_options/index')->with('success', 'success')->with('message', 'Successfully updated item option!');
        } else {
            return Redirect::back()->withErrors('Failed to update item option. Please try again.')->withInput();
        }
    }

    public function view_itemOption(Request $request, $id)
    {
        $itemOption = ItemOptions::findOrFail($id);
        return view('setup.item_options.view', compact('itemOption'));
    }

    //-- END OF ITEM OPTIONS --//

    //-- 2.13.4 --> WICKED-O-METER --//

    public function wicked_o_meter()
    {
        $wickedoMeters = WickedoMeter::where('status', 'active')->orderBy('idx')->get();
        return view('setup.wicked_o_meter.index', compact('wickedoMeters'));
    }

    public function edit_wickedoMeter($id)
    {
        $wickedoMeter = WickedoMeter::findOrFail($id);
        return view('setup.wicked_o_meter.edit', compact('wickedoMeter'));
    }

    public function new_wickedoMeter()
    {
        return view('setup.wicked_o_meter.new');
    }

    public function store_wickedoMeter(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:wicked_o_meter',
            'abbreviation'  => 'nullable|unique:wicked_o_meter',
            'idx'           => 'required|numeric',
        ]);
        $save = WickedoMeter::store_wickedoMeter($request);

        if ($save !== false) {
                return redirect('/wicked_o_meter/index')->with('success', 'success')->with('message', 'Successfully created new print!');
        } else {
            return Redirect::back()->withErrors('Failed to create print. Please try again.')->withInput();
        }
    }

    public function update_wickedoMeter(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:wicked_o_meter,name,'.$id.',wicked_o_meter_id',
            'abbreviation'  => 'nullable|unique:wicked_o_meter,abbreviation,'.$id.',wicked_o_meter_id',
            'idx'           => 'required|numeric',
        ]);
        $update  = WickedoMeter::update_wickedoMeter($request, $id);

        if ($update !== false) {
            return redirect('/wicked_o_meter/index')->with('success', 'success')->with('message', 'Successfully updated print!');
        } else {
            return Redirect::back()->withErrors('Failed to update print. Please try again.')->withInput();
        }
    }

    public function view_wickedoMeter(Request $request, $id)
    {
        $wickedoMeter = WickedoMeter::findOrFail($id);
        return view('setup.wicked_o_meter.view', compact('wickedoMeter'));
    }

    //-- END OF WICKED-O-METER --//

    //-- 2.13.5 --> UNIT OF MEASURES --//

    public function unit_of_measures()
    {
        $unitOfMeasures = UnitOfMeasures::where('status', 'active')->orderBy('idx')->get();
        foreach ($unitOfMeasures as $unitOfMeasure) {
            $subunit = UnitOfMeasures::where('unit_type_id', $unitOfMeasure->subunit_type_id)->get();
            $unitOfMeasure['subunit'] = $subunit;
        }
        return view('setup.unit_of_measures.index', compact('unitOfMeasures'));
    }

    public function edit_unitOfMeasure($id)
    {
        $unitOfMeasure = UnitOfMeasures::findOrFail($id);
        $unitOfMeasures = UnitOfMeasures::all('name');
        return view('setup.unit_of_measures.edit', compact('unitOfMeasure', 'unitOfMeasures'));
    }

    public function new_unitOfMeasure()
    {
        $unitOfMeasures = UnitOfMeasures::all('name');
        return view('setup.unit_of_measures.new', compact('unitOfMeasures'));
    }

    public function store_unitOfMeasure(Request $request)
    {
        $request->validate([
            'name'                  => 'required|unique:unit_of_measures',
            'abbreviation'          => 'nullable|unique:unit_of_measures',
            'plural_name'           => 'nullable',
            'plural_abbreviation'   => 'nullable',
            'conversion_rate'       => 'nullable|numeric',
            'base_unit'             => 'nullable|numeric',
            'subunit_type_id'       => 'nullable',
        ]);
        $save = UnitOfMeasures::store_unitOfMeasure($request);

        if ($save !== false) {
                return redirect('/unit_of_measures/index')->with('success', 'success')->with('message', 'Successfully created new unit of measure!');
        } else {
            return Redirect::back()->withErrors('Failed to create unit of measure. Please try again.')->withInput();
        }
    }

    public function update_unitOfMeasure(Request $request, $id)
    {
        $request->validate([
            'name'                  => 'required|unique:unit_of_measures,name,'.$id.',unit_type_id',
            'abbreviation'          => 'nullable|unique:unit_of_measures,abbreviation,'.$id.',unit_type_id',
            'plural_name'           => 'nullable',
            'plural_abbreviation'   => 'nullable',
            'conversion_rate'       => 'nullable|numeric',
            'base_unit'             => 'nullable|numeric',
            'subunit_type_id'       => 'nullable',
        ]);
        $update  = UnitOfMeasures::update_unitOfMeasure($request, $id);

        if ($update !== false) {
            return redirect('/unit_of_measures/index')->with('success', 'success')->with('message', 'Successfully updated unit of measure!');
        } else {
            return Redirect::back()->withErrors('Failed to update unit of measure. Please try again.')->withInput();
        }
    }

    public function view_unitOfMeasure(Request $request, $id)
    {
        $unitOfMeasure = UnitOfMeasures::findOrFail($id);
        $unitOfMeasures = DB::table('unit_of_measures as a')
            ->join('unit_of_measures as b', 'a.subunit_type_id', '=', 'b.unit_type_id')
            ->where('a.unit_type_id', $id)
            ->select('a.name as aname', 'b.name as bname')
            ->get();
        return view('setup.unit_of_measures.view', compact('unitOfMeasure', 'unitOfMeasures'));
    }

    //-- END OF UNIT OF MEASURES --//

    //-- 2.13.5 --> WEIGHT UNITS --//

    public function weight_units()
    {
        $weightUnits = WeightUnits::where('status', 'active')->orderBy('idx')->get();
        foreach ($weightUnits as $weightUnit) {
            $subweight = WeightUnits::where('weight_unit_id', $weightUnit->subweight_unit_id)->get();
            $weightUnit['subweight'] = $subweight;
        }
        return view('setup.weight_units.index', compact('weightUnits'));
    }

    public function edit_weightUnit($id)
    {
        $weightUnit = WeightUnits::findOrFail($id);
        $weightUnits = WeightUnits::all('name');
        return view('setup.weight_units.edit', compact('weightUnit', 'weightUnits'));
    }

    public function new_weightUnit()
    {
        $weightUnits = WeightUnits::all('name');
        return view('setup.weight_units.new', compact('weightUnits'));
    }

    public function store_weightUnit(Request $request)
    {
        $request->validate([
            'name'              => 'required|unique:weight_units',
            'abbreviation'      => 'nullable|max:10||unique:weight_units',
            'base_unit'         => 'nullable|numeric',
            'subweight_unit_id' => 'nullable',
            'idx'               => 'nullable',
        ]);
        $save = WeightUnits::store_weightUnit($request);

        if ($save !== false) {
                return redirect('/weight_units/index')->with('success', 'success')->with('message', 'Successfully created new weight unit!');
        } else {
            return Redirect::back()->withErrors('Failed to create weight unit. Please try again.')->withInput();
        }
    }

    public function update_weightUnit(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required|unique:weight_units,name,'.$id.',weight_unit_id',
            'abbreviation'      => 'nullable|max:10||unique:weight_units,abbreviation,'.$id.',weight_unit_id',
            'base_unit'         => 'nullable|numeric',
            'subweight_unit_id' => 'nullable',
            'idx'               => 'nullable',
        ]);
        $update  = WeightUnits::update_weightUnit($request, $id);

        if ($update !== false) {
            return redirect('/weight_units/index')->with('success', 'success')->with('message', 'Successfully updated weight unit!');
        } else {
            return Redirect::back()->withErrors('Failed to update weight unit. Please try again.')->withInput();
        }
    }

    public function view_weightUnit(Request $request, $id)
    {
        $weightUnit = WeightUnits::findOrFail($id);
        $weightUnits = DB::table('weight_units as a')
            ->join('weight_units as b', 'a.subweight_unit_id', '=', 'b.weight_unit_id')
            ->where('a.weight_unit_id', $id)
            ->select('a.name as aname', 'b.name as bname')
            ->get();

        return view('setup.weight_units.view', compact('weightUnit', 'weightUnits'));
    }

    //-- END OF WEIGHT UNITS --//

    //-- 2.13.6 --> BINS --//

    public function bins()
    {
        $bins = Bins::with('Locations:name')->get();

        return view('setup.bins.index', compact('bins'));
    }

    public function edit_bin($id)
    {
        $bin = Bins::findOrFail($id);
        $locations = Locations::all('name');
        return view('setup.bins.edit', compact('bin', 'locations'));
    }

    public function new_bin()
    {
        $locations = Locations::all('name');
        return view('setup.bins.new', compact('locations'));
    }

    public function store_bin(Request $request)
    {
        $request->validate([
            'bin_no'        => 'required|numeric|unique:bins',
            'description'   => 'nullable',
            'location_id'   => 'required',
            'idx'           => 'required|numeric',
        ]);
        $save = Bins::store_bin($request);

        if ($save !== false) {
                return redirect('/bins/index')->with('success', 'success')->with('message', 'Successfully created new bin!');
        } else {
            return Redirect::back()->withErrors('Failed to create bin. Please try again.')->withInput();
        }
    }

    public function update_bin(Request $request, $id)
    {
        $request->validate([
            'bin_no'        => 'required|numeric|unique:bins,bin_no,'.$id.',bin_id',
            'description'   => 'nullable',
            'location_id'   => 'required',
            'idx'           => 'required|numeric',
        ]);
        $update  = Bins::update_bin($request, $id);

        if ($update !== false) {
            return redirect('/bins/index')->with('success', 'success')->with('message', 'Successfully updated bin!');
        } else {
            return Redirect::back()->withErrors('Failed to update bin. Please try again.')->withInput();
        }
    }

    public function view_bin(Request $request, $id)
    {
        $bin = Bins::findOrFail($id);
        $locations = Locations::all('name');
        return view('setup.bins.view', compact('bin', 'locations'));
    }

    //-- END OF BINS --//

    //-- 2.13.7 --> CURRENCIES --//

    public function currencies()
    {
        $currencies = Currencies::with('Countries:name')->get();
        // dd($currencies);
        return view('setup.currencies.index', compact('currencies'));
    }

    public function edit_currency($id)
    {
        $currency = Currencies::findOrFail($id);
        $countries = Countries::all('name');
        return view('setup.currencies.edit', compact('currency', 'countries'));
    }

    public function new_currency()
    {
        $countries = Countries::all('name');
        return view('setup.currencies.new', compact('countries'));
    }

    public function store_currency(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:currencies',
            'country_id'    => 'required',
            'iso_code'      => 'required',
            'symbol'        => 'nullable',
            'idx'           => 'required|numeric',
        ]);
        $save = Currencies::store_currency($request);

        if ($save !== false) {
                return redirect('/currencies/index')->with('success', 'success')->with('message', 'Successfully created new currency!');
        } else {
            return Redirect::back()->withErrors('Failed to create currency. Please try again.')->withInput();
        }
    }

    public function update_currency(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:currencies,name,'.$id.',currency_id',
            'country_id'    => 'required',
            'iso_code'      => 'required',
            'symbol'        => 'nullable',
            'idx'           => 'required|numeric',
        ]);
        $update  = Currencies::update_currency($request, $id);

        if ($update !== false) {
            return redirect('/currencies/index')->with('success', 'success')->with('message', 'Successfully updated currency!');
        } else {
            return Redirect::back()->withErrors('Failed to update currency. Please try again.')->withInput();
        }
    }

    public function view_currency(Request $request, $id)
    {
        $currency = Currencies::findOrFail($id);
        $countries = Countries::all('name');
        return view('setup.currencies.view', compact('currency', 'countries'));
    }

    //-- END OF CURRENCIES --//

    //-- 2.13.7 --> EXCHANE RATES --//

    public function exchange_rates()
    {
        $exchangeRates = ExchangeRates::with('Currencies:name')->get();
        return view('setup.exchange_rates.index', compact('exchangeRates'));
    }

    public function edit_exchangeRate($id)
    {
        $exchangeRate = ExchangeRates::findOrFail($id);
        $currencies = Currencies::all('name');
        return view('setup.exchange_rates.edit', compact('exchangeRate', 'currencies'));
    }

    public function new_exchangeRate()
    {
        $currencies = Currencies::all('name');
        return view('setup.exchange_rates.new', compact('currencies'));
    }

    public function store_exchangeRate(Request $request)
    {
        $request->validate([
            'currency_id'       => 'required',
            'amount'            => 'required|numeric',
            'effective_date'    => 'required',
        ]);
        $save = ExchangeRates::store_exchangeRate($request);

        if ($save !== false) {
                return redirect('/exchange_rates/index')->with('success', 'success')->with('message', 'Successfully created new exchange rate!');
        } else {
            return Redirect::back()->withErrors('Failed to create exchange rate. Please try again.')->withInput();
        }
    }

    public function update_exchangeRate(Request $request, $id)
    {
        $request->validate([
            'currency_id'       => 'required',
            'amount'            => 'required|numeric',
            'effective_date'    => 'required',
        ]);
        $update  = ExchangeRates::update_exchangeRate($request, $id);

        if ($update !== false) {
            return redirect('/exchange_rates/index')->with('success', 'success')->with('message', 'Successfully updated exchange rate!');
        } else {
            return Redirect::back()->withErrors('Failed to update exchange rate. Please try again.')->withInput();
        }
    }

    public function view_exchangeRate(Request $request, $id)
    {
        $exchangeRate = ExchangeRates::findOrFail($id);
        $currencies = Currencies::all('name');
        // dd($currencies);
        return view('setup.exchange_rates.view', compact('exchangeRate', 'currencies'));
    }

    //-- END OF EXCHANE RATES --//

    //-- 2.13.8 --> SHIPPING CARRIER --//

    public function shipping_carrier()
    {
        $shippingCarriers = ShippingCarrier::where('status', 'active')->orderBy('idx')->get();
        return view('setup.shipping_carrier.index', compact('shippingCarriers'));
    }

    public function edit_shippingCarrier($id)
    {
        $shippingCarrier = ShippingCarrier::findOrFail($id);
        return view('setup.shipping_carrier.edit', compact('shippingCarrier'));
    }

    public function new_shippingCarrier()
    {
        return view('setup.shipping_carrier.new');
    }

    public function store_shippingCarrier(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:shipping_carrier',
            'description'   => 'nullable',
        ]);
        $save = ShippingCarrier::store_shippingCarrier($request);

        if ($save !== false) {
                return redirect('/shipping_carrier/index')->with('success', 'success')->with('message', 'Successfully created new shipping carrier!');
        } else {
            return Redirect::back()->withErrors('Failed to create shipping carrier. Please try again.')->withInput();
        }
    }

    public function update_shippingCarrier(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:shipping_carrier,name,'.$id.',shipping_carrier_id',
            'description'   => 'nullable',
        ]);
        $update  = ShippingCarrier::update_shippingCarrier($request, $id);

        if ($update !== false) {
            return redirect('/shipping_carrier/index')->with('success', 'success')->with('message', 'Successfully updated shipping carrier!');
        } else {
            return Redirect::back()->withErrors('Failed to update shipping carrier. Please try again.')->withInput();
        }
    }

    public function view_shippingCarrier(Request $request, $id)
    {
        $shippingCarrier = ShippingCarrier::findOrFail($id);
        return view('setup.shipping_carrier.view', compact('shippingCarrier'));
    }

    //-- END OF SHIPPING CARRIER --//

    //-- 2.13.4 --> COUNTRIES --//

    public function countries()
    {
        $countries = Countries::where('status', 'active')->orderBy('idx')->get();
        return view('setup.countries.index', compact('countries'));
    }

    public function edit_country($id)
    {
        $country = Countries::findOrFail($id);
        return view('setup.countries.edit', compact('country'));
    }

    public function new_country()
    {
        return view('setup.countries.new');
    }

    public function store_country(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:countries',
            'abbreviation'  => 'nullable',
            'area_code'     => 'nullable',
            'idx'           => 'nullable|numeric',
        ]);
        $save = Countries::store_country($request);

        if ($save !== false) {
                return redirect('/countries/index')->with('success', 'success')->with('message', 'Successfully created new country!');
        } else {
            return Redirect::back()->withErrors('Failed to create country. Please try again.')->withInput();
        }
    }

    public function update_country(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:countries,name,'.$id.',country_id',
            'abbreviation'  => 'nullable',
            'area_code'     => 'nullable',
            'idx'           => 'nullable|numeric',
        ]);
        $update  = Countries::update_country($request, $id);

        if ($update !== false) {
            return redirect('/countries/index')->with('success', 'success')->with('message', 'Successfully updated country!');
        } else {
            return Redirect::back()->withErrors('Failed to update country. Please try again.')->withInput();
        }
    }

    public function view_country(Request $request, $id)
    {
        $country = Countries::findOrFail($id);
        return view('setup.countries.view', compact('country'));
    }

    //-- END OF COUNTRIES --//

    //-- 2.13.4 --> TAX CODES --//

    public function tax_codes()
    {
        $taxCodes = TaxCodes::where('status', 'active')->orderBy('idx')->get();
        return view('setup.tax_codes.index', compact('taxCodes'));
    }

    public function edit_taxCode($id)
    {
        $taxCode = TaxCodes::findOrFail($id);
        return view('setup.tax_codes.edit', compact('taxCode'));
    }

    public function new_taxCode()
    {
        return view('setup.tax_codes.new');
    }

    public function store_taxCode(Request $request)
    {
        $request->validate([
            'code'              => 'required|unique:tax_codes',
            'description'       => 'nullable',
            'rate'              => 'nullable|numeric',
            'effective_from'    => 'nullable',
            'valid_until'       => 'nullable',
            'tax_agency'        => 'nullable',
        ]);
        $save = TaxCodes::store_taxCode($request);

        if ($save !== false) {
                return redirect('/tax_codes/index')->with('success', 'success')->with('message', 'Successfully created new tax code!');
        } else {
            return Redirect::back()->withErrors('Failed to create tax code. Please try again.')->withInput();
        }
    }

    public function update_taxCode(Request $request, $id)
    {
        $request->validate([
            'code'              => 'required|unique:tax_codes,code,'.$id.',tax_code_id',
            'description'       => 'nullable',
            'rate'              => 'nullable|numeric',
            'effective_from'    => 'nullable',
            'valid_until'       => 'nullable',
            'tax_agency'        => 'nullable',
        ]);
        $update  = TaxCodes::update_taxCode($request, $id);

        if ($update !== false) {
            return redirect('/tax_codes/index')->with('success', 'success')->with('message', 'Successfully updated tax code!');
        } else {
            return Redirect::back()->withErrors('Failed to update tax code. Please try again.')->withInput();
        }
    }

    public function view_taxCode(Request $request, $id)
    {
        $taxCode = TaxCodes::findOrFail($id);
        return view('setup.tax_codes.view', compact('taxCode'));
    }

    //-- END OF TAX CODES --//

    //-- 2.13.4 --> TAX TYPES --//

    public function tax_types()
    {
        $taxTypes = TaxTypes::where('status', 'active')->orderBy('idx')->get();
        return view('setup.tax_types.index', compact('taxTypes'));
    }

    public function edit_taxType($id)
    {
        $taxType = TaxTypes::findOrFail($id);
        return view('setup.tax_types.edit', compact('taxType'));
    }

    public function new_taxType()
    {
        return view('setup.tax_types.new');
    }

    public function store_taxType(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:tax_types',
            'description'   => 'nullable',
            'idx'           => 'required|numeric',
        ]);
        $save = TaxTypes::store_taxType($request);

        if ($save !== false) {
                return redirect('/tax_types/index')->with('success', 'success')->with('message', 'Successfully created new tax type!');
        } else {
            return Redirect::back()->withErrors('Failed to create tax type. Please try again.')->withInput();
        }
    }

    public function update_taxType(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|unique:tax_types,code,'.$id.',tax_type_id',
            'description'   => 'nullable',
            'idx'           => 'required|numeric',
        ]);
        $update  = TaxTypes::update_taxType($request, $id);

        if ($update !== false) {
            return redirect('/tax_types/index')->with('success', 'success')->with('message', 'Successfully updated tax type!');
        } else {
            return Redirect::back()->withErrors('Failed to update tax type. Please try again.')->withInput();
        }
    }

    public function view_taxType(Request $request, $id)
    {
        $taxType = TaxTypes::findOrFail($id);
        return view('setup.tax_types.view', compact('taxType'));
    }
}
