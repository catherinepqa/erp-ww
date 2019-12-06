<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductModel extends Model
{

    public static function getItems()
    {
        $items = DB::table("items")
                    ->select('items.*')
                    ->orderBy('item_id')
                    ->get();

         return $items;
    }

	public static function getUnitOfMeasuresByUnitTypeID($unitTypeID)
    {
    	$unit_type = DB::table("unit_of_measures")
    					->select('unit_of_measures.unit_type_id', 'unit_of_measures.name', 'unit_of_measures.idx')
    					->where([['unit_type_id', $unitTypeID], ['status', 'active']]);
	  
    	$subunit_type = DB::table("unit_of_measures")
    					->select('unit_of_measures.unit_type_id', 'unit_of_measures.name', 'unit_of_measures.idx')
    					->where([['subunit_type_id', $unitTypeID], ['status', 'active']])
    					->union($unit_type)
    					->orderBy('idx')
    					->get();

    	 return $subunit_type;
    }

    public static function getItemsByName($request)
    {
       $items = DB::table("items")
                    ->join('unit_of_measures', 'items.unit_type', '=', 'unit_of_measures.unit_type_id')
                    ->join('tax_codes', 'items.tax_code', '=', 'tax_codes.tax_code_id')
                    ->join('tax_types', 'tax_codes.tax_type_id', '=', 'tax_types.tax_type_id')
                    ->select('items.item_id', 'items.item_name as name', 'items.item_description', 'unit_of_measures.unit_type_id', 'unit_of_measures.abbreviation as unit_type', 'tax_codes.tax_code_id', 'tax_codes.code as tax_code', 'tax_codes.rate as tax_rate', 'tax_types.name as tax_type')
                    ->where('items.item_name', 'LIKE', "%{$request->itemName}%")
                    ->orderBy('items.item_name')
                    ->get();

         return $items;
    }

    public static function getTaxCode()
    {
       $items = DB::table("tax_codes")
                    ->join('tax_types', 'tax_codes.tax_type_id', '=', 'tax_types.tax_type_id')
                    ->select('tax_codes.tax_code_id', 'tax_codes.code as tax_code', 'tax_codes.rate as tax_rate', 'tax_types.name as tax_type')
                    ->where('tax_codes.status', 'active')
                    ->orderBy('tax_type')
                    ->orderBy('tax_code')
                    ->get();

         return $items;
    }

    public static function createItem($request)
    {
        $data = [
            'item_type_id' => 1, 
            'item_code' => $request->itemCode,
            'item_name' => $request->itemName, 
            'item_description' => $request->itemDescription, 
            'upc_code' => ($request->upcCode == '') ? NULL : $request->upcCode,
            'external_id' => ($request->externalID == '') ? NULL : $request->externalID,
            'wicked_o_meter_id' => ($request->wickedOMeter =='') ? NULL : $request->wickedOMeter,
            'item_bom_barcode' => ($request->itemBOMBarcode == '') ? NULL : $request->itemBOMBarcode,
            'production_team_id' => ($request->productionTeam == '') ? NULL : $request->productionTeam,
            'item_style' => ($request->itemStyle == '') ? NULL : $request->itemStyle,
            'item_style_description' => ($request->itemStyleDescription == '') ? NULL : $request->itemStyleDescription,
            'item_classification' => ($request->itemClassification == '') ? NULL : $request->itemClassification,
            'item_options' => ($request->itemOptions == '') ? NULL : json_encode($request->itemOptions),
            'product_category' => ($request->productCategory == '') ? NULL : json_encode($request->productCategory),
            'release_date' => date('Y-m-d', strtotime($request->releaseDate)),
            'oversell' => ($request->oversell == '') ? NULL : $request->oversell,
            'unit_type' => $request->unitType,
            'stock_unit' => $request->stockUnit,
            'purchase_unit' => $request->purchaseUnit,
            'sale_unit' => $request->salesUnit,
            'consumption_unit' => $request->consumptionUnit,
            'base_unit' => $request->baseUnit,
            'department_id' => $request->departmentID,
            'item_category_id' => ($request->itemCategoryID == '') ? NULL : $request->itemCategoryID,
            'location_id' => $request->locationId,
            'track_landed_cost' => ($request->trackLandedCost == '') ? NULL : $request->trackLandedCost,
            'costing_method_id' => ($request->costingMethodID == '') ? NULL : $request->costingMethodID,
            'purchase_price' => ($request->purchasePrice == '') ? NULL : $request->purchasePrice,
            'purchase_description' => ($request->purchaseDescription == '') ? NULL : $request->purchaseDescription,
            'stock_description' => ($request->stockDescription == '') ? NULL : $request->stockDescription,
            'use_bins' => ($request->useBins == '') ? NULL : $request->useBins,
            'manufacturer' => ($request->manufacturer == '') ? NULL : $request->manufacturer,
            'mpn' => ($request->mpn == '') ? NULL : $request->mpn,
            'manufacturer_country' => ($request->manufacturerCountry == '') ? NULL : $request->manufacturerCountry,
            'matrix_item_name_template' => $request->matrixItemNameTemplate,
            'style' => json_encode($request->style),
            'fabric' => json_encode($request->fabric),
            'colour' => json_encode($request->colour),
            'top_size' => ($request->topSize == '') ? NULL : json_encode($request->topSize),
            'size' => json_encode($request->size),
            'back_variation' => ($request->backVariation == '') ? NULL : json_encode($request->backVariation),
            'style_variation' => ($request->styleVariation == '') ? NULL : json_encode($request->styleVariation),
            'print' => ($request->print == '') ? NULL : json_encode($request->print),
            'trouser_length' => ($request->trouserLength == '') ? NULL : json_encode($request->trouserLength),
            'cost_estimate_type_id' => ($request->costEstimateTypeID == '') ? NULL : $request->costEstimateTypeID,
            'item_defined_cost' => ($request->itemDefinedCost == '') ? NULL : $request->itemDefinedCost,
            'minimum_quantity' => ($request->minimumQuantity == '') ? NULL : $request->minimumQuantity,
            'item_weight' => ($request->itemWeight == '') ? NULL : $request->itemWeight,
            'weight_unit_id' => ($request->weightUnitID == '') ? NULL : $request->weightUnitID,
            'shipping_cost' => ($request->shippingCost == '') ? NULL : $request->shippingCost,
            'handling_cost' => ($request->handlingCost == '') ? NULL : $request->handlingCost,
            'ships_individualy' => ($request->shipsIndividually == '') ? NULL : $request->shipsIndividually,
            'price_included_tax' => ($request->pricesIncludedTax == '') ? NULL : $request->pricesIncludedTax,
            'tax_code' => $request->taxCode,
            'purchase_tax_code' => ($request->purchaseTaxCode == '') ? NULL : $request->purchaseTaxCode,
            'display_on_web' => ($request->displayInWeb == '') ? NULL : $request->displayInWeb,
            'display_name' => ($request->webstoreDisplayName == '') ? NULL : $request->webstoreDisplayName,
            'detailed_description' => ($request->detailedDescription == '') ? NULL : $request->detailedDescription,
            'featured_description' => ($request->featuredDescription == '') ? NULL : $request->featuredDescription,
            'created_by' => 1,
            'dt_created' => date('Y-m-d H:i:s'),
            'status' => 'Active'
        ];

        if (DB::table('items')->insert($data)) {
            $id = DB::getPdo()->lastInsertId();

            if ($request->inventoryItems) self::createInventoryItems($id, $request->inventoryItems);
            if ($request->bom) self::createBOM($id, $request->bom);
            if ($request->bins) self::createBins($id, $request->bins);
            if ($request->priceLevels) self::createPriceLevels($id, $request->priceLevels);

            self::createSubItems($id, $request);

            return ['success' => true, 'id' => $id];
        }
    }

    public static function createInventoryItems($id, $dt)
    { 
        for ($i = 0; $i < count($dt); $i++) {
            $data = [
                'item_id' => $id, 
                'location_id' => $dt[$i]['locationID'], 
                'build_point' => ($dt[$i]['buildPoint'] == '') ? NULL : $dt[$i]['buildPoint'],
                'preferred_stock_level' => ($dt[$i]['preferredStockLevel'] == '') ? NULL : $dt[$i]['preferredStockLevel'],
                'default_return_cost' => ($dt[$i]['defaultReturnCost'] == '') ? NULL : $dt[$i]['defaultReturnCost'],
                'created_by' => 1,
                'dt_created' => date('Y-m-d H:i:s'),
                'status' => 'Active'
            ];

            DB::table('inventory_items')->insert($data);
        }
    }

    public static function createBOM($id, $dt)
    { 
        for ($i = 0; $i < count($dt); $i++) {
            $data = [
                'item_id' => $id, 
                'reference_id' => $dt[$i]['referenceID'], 
                'item_source_id' =>  $dt[$i]['itemSourceID'], 
                'quantity' => $dt[$i]['quantity'],
                'effective_date' => ($dt[$i]['effectivDate'] == '') ? NULL : date('Y-m-d', strtotime($dt[$i]['effectivDate'])),
                'obselete_date' => ($dt[$i]['obseleteDate'] == '') ? NULL : date('Y-m-d', strtotime($dt[$i]['obseleteDate'])),
                'created_by' => 1,
                'dt_created' => date('Y-m-d H:i:s'),
                'status' => 'Active'
            ];

            DB::table('bom_items')->insert($data);
        }
    }

    public static function createBins($id, $dt)
    { 
        for ($i = 0; $i < count($dt); $i++) {
            $data = [
                'item_id' => $id, 
                'location_id' => $dt[$i]['locationID'], 
                'bin_id' =>  $dt[$i]['binID'], 
                'preferred_per_location' => $dt[$i]['preferredPerLocation'],
                'created_by' => 1,
                'dt_created' => date('Y-m-d H:i:s'),
                'status' => 'Active'
            ];

            DB::table('bin_items')->insert($data);
        }
    }

    public static function createPriceLevels($id, $dt)
    { 
        for ($i = 0; $i < count($dt); $i++) {
            $data = [
                'item_id' => $id, 
                'currency_id' => $dt[$i]['currencyID'], 
                'amount' =>  $dt[$i]['amount'], 
                'created_by' => 1,
                'dt_created' => date('Y-m-d H:i:s'),
                'status' => 'Active'
            ];

            DB::table('price_levels')->insert($data);
        }
    }

    public static function createSubItems($id, $request)
    { 
        $style_id = $request->style[0];

        $fabric = $request->fabric;
        for ($f = 0; $f< count($fabric); $f++) {
            $fabric_id = $fabric[$f][0];
            
            $colour = $request->colour;
            for ($c = 0; $c< count($colour); $c++) {
                $colour_id = $colour[$c][0];

                $size = $request->size;
                for ($s = 0; $s< count($size); $s++) {
                    $size_id = $size[$s][0];

                    $data = [
                        'item_type_id' => 1, 
                        'subitem_id' => $id, 
                        'item_code' => $style_id. '-' .$fabric_id. '-' .$colour_id. '-' .$size_id,
                        'item_name' => $request->itemName. ' : ' .$fabric_id. ' :' .$colour_id. ' : ' .$size_id, 
                        'item_description' => $request->itemDescription, 
                        'upc_code' => ($request->upcCode == '') ? NULL : $request->upcCode,
                        'external_id' => ($request->externalID == '') ? NULL : $request->externalID,
                        'wicked_o_meter_id' => ($request->wickedOMeter == '') ? NULL : $request->wickedOMeter,
                        'production_team_id' => ($request->productionTeam == '') ? NULL : $request->productionTeam,
                        'item_style' => ($request->itemStyle == '') ? NULL : $request->itemStyle,
                        'item_style_description' => ($request->itemStyleDescription == '') ? NULL : $request->itemStyleDescription,
                        'item_classification' => ($request->itemClassification == '') ? NULL : $request->itemClassification,
                        'item_options' => ($request->itemOptions == '') ? NULL : json_encode($request->itemOptions),
                        'product_category' => ($request->productCategory == '') ? NULL : json_encode($request->productCategory),
                        'release_date' => date('Y-m-d', strtotime($request->releaseDate)),
                        'oversell' => ($request->oversell == '') ? NULL : $request->oversell,
                        'unit_type' => $request->unitType,
                        'stock_unit' => $request->stockUnit,
                        'purchase_unit' => $request->purchaseUnit,
                        'sale_unit' => $request->salesUnit,
                        'consumption_unit' => $request->consumptionUnit,
                        'base_unit' => $request->baseUnit,
                        'department_id' => $request->departmentID,
                        'item_category_id' => ($request->itemCategoryID == '') ? NULL : $request->itemCategoryID,
                        'location_id' => $request->locationId,
                        'track_landed_cost' => ($request->trackLandedCost == '') ? NULL : $request->trackLandedCost,
                        'costing_method_id' => ($request->costingMethodID == '') ? NULL : $request->costingMethodID,
                        'purchase_price' => ($request->purchasePrice == '') ? NULL : $request->purchasePrice,
                        'purchase_description' => ($request->purchaseDescription == '') ? NULL : $request->purchaseDescription,
                        'stock_description' => ($request->stockDescription == '') ? NULL : $request->stockDescription,
                        'use_bins' => ($request->useBins == '') ? NULL : $request->useBins,
                        'manufacturer' => ($request->manufacturer == '') ? NULL : $request->manufacturer,
                        'mpn' => ($request->mpn == '') ? NULL : $request->mpn,
                        'manufacturer_country' => ($request->manufacturerCountry == '') ? NULL : $request->manufacturerCountry,
                        'matrix_item_name_template' => $request->matrixItemNameTemplate,
                        'style' => json_encode([$style_id]),
                        'fabric' => json_encode([$fabric_id]),
                        'colour' => json_encode([$colour_id]),
                        'top_size' => ($request->topSize == '') ? NULL : json_encode($request->topSize),
                        'size' => json_encode([$size_id]),
                        'back_variation' => ($request->backVariation == '') ? NULL : json_encode($request->backVariation),
                        'style_variation' => ($request->styleVariation == '') ? NULL : json_encode($request->styleVariation),
                        'print' => ($request->print == '') ? NULL : json_encode($request->print),
                        'trouser_length' => ($request->trouserLength == '') ? NULL : json_encode($request->trouserLength),
                        'cost_estimate_type_id' => ($request->costEstimateTypeID == '') ? NULL : $request->costEstimateTypeID,
                        'item_defined_cost' => ($request->itemDefinedCost == '') ? NULL : $request->itemDefinedCost,
                        'minimum_quantity' => ($request->minimumQuantity == '') ? NULL : $request->minimumQuantity,
                        'item_weight' => ($request->itemWeight == '') ? NULL : $request->itemWeight,
                        'weight_unit_id' => ($request->weightUnitID == '') ? NULL : $request->weightUnitID,
                        'shipping_cost' => ($request->shippingCost == '') ? NULL : $request->shippingCost,
                        'handling_cost' => ($request->handlingCost == '') ? NULL : $request->handlingCost,
                        'ships_individualy' => ($request->shipsIndividually == '') ? NULL : $request->shipsIndividually,
                        'price_included_tax' => ($request->pricesIncludedTax == '') ? NULL : $request->pricesIncludedTax,
                        'tax_code' => $request->taxCode,
                        'purchase_tax_code' => $request->purchaseTaxCode,
                        'display_on_web' => ($request->displayInWeb == '') ? NULL : $request->displayInWeb,
                        'display_name' => ($request->webstoreDisplayName == '') ? NULL : $request->webstoreDisplayName,
                        'detailed_description' => ($request->detailedDescription == '') ? NULL : $request->detailedDescription,
                        'featured_description' => ($request->featuredDescription == '') ? NULL : $request->featuredDescription,
                        'created_by' => 1,
                        'dt_created' => date('Y-m-d H:i:s'),
                        'status' => 'Active'
                    ];

                    DB::table('items')->insert($data);
                }
            }
        }
    }

    public static function getItemsByItemID($id)
    {
        /* 
        $items = DB::table("items")
                    ->select("items.*", 
                        DB::raw("(SELECT name FROM wicked_o_meter WHERE wicked_o_meter_id = items.wicked_o_meter_id) AS wicked_o_meter"),
                        DB::raw("(SELECT name FROM production_team WHERE production_team_id = items.production_team_id) AS production_team"),
                       
                        DB::raw("(SELECT GROUP_CONCAT(name) FROM item_options WHERE FIND_IN_SET(item_option_id, REPLACE(REPLACE(REPLACE(items.item_options,'[',''),']',''),'\"',''))) AS item_option"))
                       
                    ->where('item_id', '=', $id)
                    ->first();
        */


        $sql = "SELECT 
            i.*, 
            CASE WHEN i.subitem_id IS NOT NULL THEN
                (SELECT item_name FROM items WHERE item_id = i.subitem_id)
            END subitem,
            wicked_o_meter.name wicked_o_meter, 
            production_team.name production_team, 
            REPLACE(GROUP_CONCAT(DISTINCT item_options.name ORDER BY item_options.idx),',',', ') item_option_description,
            REPLACE(GROUP_CONCAT(DISTINCT product_categories.name ORDER BY product_categories.idx),',',', ') product_category_descripton,
            GROUP_CONCAT(DISTINCT CASE WHEN unit_of_measures.unit_type_id = i.unit_type THEN unit_of_measures.name END) unit_type_descripton,
            GROUP_CONCAT(DISTINCT CASE WHEN unit_of_measures.unit_type_id = i.stock_unit THEN unit_of_measures.name END) stock_unit_descripton,
            GROUP_CONCAT(DISTINCT CASE WHEN unit_of_measures.unit_type_id = i.purchase_unit THEN unit_of_measures.name END) purchase_unit_descripton,
            GROUP_CONCAT(DISTINCT CASE WHEN unit_of_measures.unit_type_id = i.sale_unit THEN unit_of_measures.name END) sale_unit_descripton,
            GROUP_CONCAT(DISTINCT CASE WHEN unit_of_measures.unit_type_id = i.consumption_unit THEN unit_of_measures.name END) consumption_unit_descripton,
            departments.name department,
            item_categories.description item_category,
            locations.name location,
            costing_method.name costing_method,
            countries.name manufacturer_country_descripton,
            REPLACE(GROUP_CONCAT(DISTINCT styles.name ORDER BY styles.idx),',',', ') style_descripton,
            REPLACE(GROUP_CONCAT(DISTINCT fabric.name ORDER BY fabric.idx),',',', ') fabric_descripton,
            REPLACE(GROUP_CONCAT(DISTINCT colour.name ORDER BY colour.idx),',',', ') colour_descripton,
            REPLACE(GROUP_CONCAT(DISTINCT top_sizes.name ORDER BY top_sizes.idx),',',', ') top_size_descripton,
            REPLACE(GROUP_CONCAT(DISTINCT sizes.name ORDER BY sizes.idx),',',', ') size_descripton,
            REPLACE(GROUP_CONCAT(DISTINCT back_variations.name ORDER BY back_variations.idx),',',', ') back_variation_descripton,
            REPLACE(GROUP_CONCAT(DISTINCT style_variations.name ORDER BY style_variations.idx),',',', ') style_variation_descripton,
            REPLACE(GROUP_CONCAT(DISTINCT prints.name ORDER BY prints.idx),',',', ') print_descripton,
            REPLACE(GROUP_CONCAT(DISTINCT trouser_length.name ORDER BY trouser_length.idx),',',', ') trouser_length_descripton,
            cost_estimate_type.name cost_estimate_type,
            weight_units.abbreviation weight_unit,
            GROUP_CONCAT(DISTINCT CASE WHEN tax_codes.tax_code_id = i.tax_code THEN tax_codes.tax_code END) tax_code_description,
            GROUP_CONCAT(DISTINCT CASE WHEN tax_codes.tax_code_id = i.purchase_tax_code THEN tax_codes.tax_code END) purchase_tax_code_description
        FROM 
            items i
            LEFT JOIN wicked_o_meter
                ON (wicked_o_meter.wicked_o_meter_id = i.wicked_o_meter_id)
            LEFT JOIN production_team
                ON (production_team.production_team_id = i.production_team_id)
            LEFT JOIN item_options
                ON (FIND_IN_SET(item_options.item_option_id, REPLACE(REPLACE(REPLACE(i.item_options,'[',''),']',''),'\"',',')))
            LEFT JOIn product_categories
                ON (FIND_IN_SET(product_categories.product_category_id, REPLACE(REPLACE(REPLACE(i.product_category,'[',''),']',''),'\"',',')))
            INNER JOIN unit_of_measures
                ON (FIND_IN_SET(unit_of_measures.unit_type_id, CONCAT(i.unit_type, ',', i.stock_unit, ',', i.purchase_unit, ',', i.sale_unit, ',', i.consumption_unit)))
            INNER JOIN departments
                ON (departments.department_id = i.department_id)
            LEFT JOIN item_categories
                ON (item_categories.item_category_id = i.item_category_id)
            INNER JOIN locations
                ON (locations.location_id = i.location_id)
            LEFT JOIn costing_method
                ON (costing_method.costing_method_id = i.costing_method_id)
            LEFT JOIN countries
                ON (countries.country_id = i.manufacturer_country)
            INNER JOIN styles
                ON (FIND_IN_SET(styles.style_id, REPLACE(REPLACE(REPLACE(i.style,'[',''),']',''),'\"',',')))
            INNER JOIN fabric
                ON (FIND_IN_SET(fabric.fabric_id, REPLACE(REPLACE(REPLACE(i.fabric,'[',''),']',''),'\"',',')))
            INNER JOIN colour
                ON (FIND_IN_SET(colour.colour_id, REPLACE(REPLACE(REPLACE(i.colour,'[',''),']',''),'\"',',')))    
            LEFT JOIN top_sizes
                ON (FIND_IN_SET(top_sizes.top_size_id, REPLACE(REPLACE(REPLACE(i.top_size,'[',''),']',''),'\"',',')))    
            INNER JOIN sizes
                ON (FIND_IN_SET(sizes.size_id, REPLACE(REPLACE(REPLACE(i.size,'[',''),']',''),'\"',',')))
            LEFT JOIN back_variations
                ON (FIND_IN_SET(back_variations.back_variation_id, REPLACE(REPLACE(REPLACE(i.back_variation,'[',''),']',''),'\"',',')))   
            LEFT JOIN style_variations
                ON (FIND_IN_SET(style_variations.style_variation_id, REPLACE(REPLACE(REPLACE(i.style_variation,'[',''),']',''),'\"',',')))
            LEFT JOIN prints
                ON (FIND_IN_SET(prints.print_id, REPLACE(REPLACE(REPLACE(i.print,'[',''),']',''),'\"',',')))
            LEFT JOIN trouser_length
                ON (FIND_IN_SET(trouser_length.trouser_length_id, REPLACE(REPLACE(REPLACE(i.trouser_length,'[',''),']',''),'\"',',')))
            LEFT JOIN cost_estimate_type
                ON (cost_estimate_type.cost_estimate_type_id = i.cost_estimate_type_id)
            LEFT JOIN weight_units
                ON (weight_units.weight_unit_id = i.weight_unit_id)
            INNER JOIN
                (
                    SELECT tax_codes.tax_code_id, CONCAT(tax_types.name, ' : ', tax_codes.code) tax_code
                    FROM tax_codes
                        INNER JOIN tax_types
                        ON (tax_types.tax_type_id = tax_codes.tax_type_id)
                ) tax_codes
                ON (FIND_IN_SET(tax_codes.tax_code_id, CONCAT(i.tax_code, ',', i.purchase_tax_code)))
        WHERE i.item_id = :id 
        GROUP BY 
            i.item_id, i.item_type_id, i.subitem_id, i.item_name, i.item_description, i.item_code, i.item_style, 
            i.item_style_description, i.item_classification, i.item_options, i.wicked_o_meter_id, i.product_category,
            i.item_bom_barcode, i.upc_code, i.release_date";

        $items = DB::select($sql, ['id' => $id])[0];

        return $items;
    }

    public static function getInventoryItemsByItemID($id)
    {
       $bins = DB::table("locations")
                    ->leftJoin('inventory_items', function($join) use ($id)
                        {
                            $join->on('inventory_items.location_id', '=', 'locations.location_id');
                            $join->on('inventory_items.item_id', '=', DB::raw($id));

                        })
                    ->select('locations.location_id', 'locations.name AS location_name', 'inventory_items.system_id', 'inventory_items.item_id', 'inventory_items.build_point', 'inventory_items.preferred_stock_level', 'inventory_items.default_return_cost')
                    ->orderBy('locations.idx')
                    ->get();

         return $bins;
    }

    public static function getBOMItemsByItemID($id)
    {
        $bins = DB::table("bom_items")
                    ->join('items', 'bom_items.reference_id', '=', 'items.item_id')
                    ->join('item_source', 'bom_items.item_source_id', '=', 'item_source.item_source_id')
                    ->join('unit_of_measures', 'items.unit_type', '=', 'unit_of_measures.unit_type_id')
                    ->join('tax_codes', 'items.tax_code', '=', 'tax_codes.tax_code_id')
                    ->join('tax_types', 'tax_codes.tax_type_id', '=', 'tax_types.tax_type_id')
                    ->select('bom_items.*', 'items.item_name', 'items.item_description', 'item_source.name AS item_source', 'unit_of_measures.unit_type_id', 'unit_of_measures.abbreviation AS unit_type', 'tax_codes.tax_code_id', 'tax_codes.code AS tax_code', 'tax_codes.rate AS tax_rate', 'tax_types.name AS tax_type')
                    ->where('bom_items.item_id', $id)
                    ->get();

         return $bins;
    }

    public static function getBinItemsByItemID($id)
    {
        $bins = DB::table("bin_items")
                    ->join('locations', 'bin_items.location_id', '=', 'locations.location_id')
                    ->join('bins', 'bin_items.bin_id', '=', 'bins.bin_id')
                    ->select('bin_items.*', 'locations.name AS location', 'bins.bin_no')
                    ->where('bin_items.item_id', $id)
                    ->get();

         return $bins;
    }

    public static function getPriceLevelsByItemID($id)
    {
       $bins = DB::table("currencies")
                    ->leftJoin('price_levels', function($join) use ($id)
                        {
                            $join->on('price_levels.currency_id', '=', 'currencies.currency_id');
                            $join->on('price_levels.item_id', '=', DB::raw($id));

                        })
                    ->select('currencies.currency_id', 'currencies.name AS currency', 'price_levels.system_id', 'price_levels.item_id', 'price_levels.amount')
                    ->orderBy('currencies.name')
                    ->get();

         return $bins;
    }


    public static function updateItem($request)
    {
        $data = [
            'item_code' => $request->itemCode,
            'item_name' => $request->itemName, 
            'item_description' => $request->itemDescription, 
            'upc_code' => ($request->upcCode == '') ? NULL : $request->upcCode,
            'external_id' => ($request->externalID == '') ? NULL : $request->externalID,
            'wicked_o_meter_id' => ($request->wickedOMeter == '') ? NULL : $request->wickedOMeter,
            'item_bom_barcode' => ($request->itemBOMBarcode == '') ? NULL : $request->itemBOMBarcode,
            'production_team_id' => ($request->productionTeam == '') ? NULL : $request->productionTeam,
            'item_style' => ($request->itemStyle == '') ? NULL : $request->itemStyle,
            'item_style_description' => ($request->itemStyleDescription == '') ? NULL : $request->itemStyleDescription,
            'item_classification' => ($request->itemClassification == '') ? NULL : $request->itemClassification,
            'item_options' => ($request->itemOptions == '') ? NULL : json_encode($request->itemOptions),
            'product_category' => ($request->productCategory == '') ? NULL : json_encode($request->productCategory),
            'release_date' => date('Y-m-d', strtotime($request->releaseDate)),
            'oversell' => ($request->oversell == '') ? NULL : $request->oversell,
            'unit_type' => $request->unitType,
            'stock_unit' => $request->stockUnit,
            'purchase_unit' => $request->purchaseUnit,
            'sale_unit' => $request->salesUnit,
            'consumption_unit' => $request->consumptionUnit,
            'base_unit' => $request->baseUnit,
            'department_id' => $request->departmentID,
            'item_category_id' => ($request->itemCategoryID == '') ? NULL : $request->itemCategoryID,
            'location_id' => $request->locationId,
            'track_landed_cost' => ($request->trackLandedCost == '') ? NULL : $request->trackLandedCost,
            'costing_method_id' => ($request->costingMethodID == '') ? NULL : $request->costingMethodID,
            'purchase_price' => ($request->purchasePrice == '') ? NULL : $request->purchasePrice,
            'purchase_description' => ($request->purchaseDescription == '') ? NULL : $request->purchaseDescription,
            'stock_description' => ($request->stockDescription == '') ? NULL : $request->stockDescription,
            'use_bins' => ($request->useBins == '') ? NULL : $request->useBins,
            'manufacturer' => ($request->manufacturer == '') ? NULL : $request->manufacturer,
            'mpn' => ($request->mpn == '') ? NULL : $request->mpn,
            'manufacturer_country' => ($request->manufacturerCountry == '') ? NULL : $request->manufacturerCountry,
            'matrix_item_name_template' => $request->matrixItemNameTemplate,
            'style' =>  json_encode($request->style),
            'fabric' => json_encode($request->fabric),
            'colour' => json_encode($request->colour),
            'top_size' => ($request->topSize == '') ? NULL : json_encode($request->topSize),
            'size' => json_encode($request->size),
            'back_variation' => ($request->backVariation == '') ? NULL : json_encode($request->backVariation),
            'style_variation' => ($request->styleVariation == '') ? NULL : json_encode($request->styleVariation),
            'print' => ($request->print == '') ? NULL : json_encode($request->print),
            'trouser_length' => ($request->trouserLength == '') ? NULL : json_encode($request->trouserLength),
            'cost_estimate_type_id' => ($request->costEstimateTypeID == '') ? NULL : $request->costEstimateTypeID,
            'item_defined_cost' => ($request->itemDefinedCost == '') ? NULL : $request->itemDefinedCost,
            'minimum_quantity' => ($request->minimumQuantity == '') ? NULL : $request->minimumQuantity,
            'item_weight' => ($request->itemWeight == '') ? NULL : $request->itemWeight,
            'weight_unit_id' => ($request->weightUnitID == '') ? NULL : $request->weightUnitID,
            'shipping_cost' => ($request->shippingCost == '') ? NULL : $request->shippingCost,
            'handling_cost' => ($request->handlingCost == '') ? NULL : $request->handlingCost,
            'ships_individualy' => ($request->shipsIndividually == '') ? NULL : $request->shipsIndividually,
            'price_included_tax' => ($request->pricesIncludedTax == '') ? NULL : $request->pricesIncludedTax,
            'tax_code' => $request->taxCode,
            'purchase_tax_code' => $request->purchaseTaxCode,
            'display_on_web' => ($request->displayInWeb == '') ? NULL : $request->displayInWeb,
            'display_name' => ($request->webstoreDisplayName == '') ? NULL : $request->webstoreDisplayName,
            'detailed_description' => ($request->detailedDescription == '') ? NULL : $request->detailedDescription,
            'featured_description' => ($request->featuredDescription == '') ? NULL : $request->featuredDescription,
            'lupd_by' => 1,
            'dt_lupd' => date('Y-m-d H:i:s')
        ];

        if (DB::table('items')->where('item_id', $request->itemID)->update($data)) {
            
            if ($request->inventoryItems) self::updateInventoryItems($request->itemID, $request->inventoryItems);
            if ($request->bom) self::updateBOM($request->itemID, $request->bom);
            if ($request->bins) self::updateBins($request->itemID, $request->bins);
            if ($request->priceLevels) self::updatePriceLevels($request->itemID, $request->priceLevels);

            //self::createSubItems($id, $request);

            return true;
        }
    }

     public static function updateInventoryItems($id, $dt)
    { 
        for ($i = 0; $i < count($dt); $i++) {
            $data = [
                'item_id' => $id, 
                'location_id' => $dt[$i]['locationID'], 
                'build_point' => ($dt[$i]['buildPoint'] == '') ? NULL : $dt[$i]['buildPoint'],
                'preferred_stock_level' => ($dt[$i]['preferredStockLevel'] == '') ? NULL : $dt[$i]['preferredStockLevel'],
                'default_return_cost' => ($dt[$i]['defaultReturnCost'] == '') ? NULL : $dt[$i]['defaultReturnCost']
            ];

            if ($dt[$i]['systemID'] == '') {
                DB::table('inventory_items')->insert(array_merge($data, ['created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active']));
            } 
            else {
                DB::table('inventory_items')->where('system_id', $dt[$i]['systemID'])->update(array_merge($data, ['lupd_by' => 1, 'dt_lupd' => date('Y-m-d H:i:s')]));
            }
        }
    }

    public static function updateBOM($id, $dt)
    { 
        for ($i = 0; $i < count($dt); $i++) {
            $data = [
                'item_id' => $id, 
                'reference_id' => $dt[$i]['referenceID'], 
                'item_source_id' =>  $dt[$i]['itemSourceID'], 
                'quantity' => $dt[$i]['quantity'],
                'effective_date' => ($dt[$i]['effectivDate'] == '') ? NULL : date('Y-m-d', strtotime($dt[$i]['effectivDate'])),
                'obselete_date' => ($dt[$i]['obseleteDate'] == '') ? NULL : date('Y-m-d', strtotime($dt[$i]['obseleteDate']))
            ];

            if ($dt[$i]['systemID'] == '') {
                DB::table('bom_items')->insert(array_merge($data, ['created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active']));
            }
            else {
                DB::table('bom_items')->where('system_id', $dt[$i]['systemID'])->update(array_merge($data, ['lupd_by' => 1, 'dt_lupd' => date('Y-m-d H:i:s')]));
            }
        }
    }

    public static function updateBins($id, $dt)
    { 
        for ($i = 0; $i < count($dt); $i++) {
            $data = [
                'item_id' => $id, 
                'location_id' => $dt[$i]['locationID'], 
                'bin_id' =>  $dt[$i]['binID'], 
                'preferred_per_location' => $dt[$i]['preferredPerLocation']
            ];

            if ($dt[$i]['systemID'] == '') {
                DB::table('bin_items')->insert(array_merge($data, ['created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active']));
            }
            else {
                DB::table('bin_items')->where('system_id', $dt[$i]['systemID'])->update(array_merge($data, ['lupd_by' => 1, 'dt_lupd' => date('Y-m-d H:i:s')]));
            }
        }
    }

    public static function updatePriceLevels($id, $dt)
    { 
        for ($i = 0; $i < count($dt); $i++) {
            $data = [
                'item_id' => $id, 
                'currency_id' => $dt[$i]['currencyID'], 
                'amount' =>  $dt[$i]['amount']
            ];

            if ($dt[$i]['systemID'] == '') {
                DB::table('price_levels')->insert(array_merge($data, ['created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active']));
            } 
            else {
                DB::table('price_levels')->where('system_id', $dt[$i]['systemID'])->update(array_merge($data, ['lupd_by' => 1, 'dt_lupd' => date('Y-m-d H:i:s')]));
            }
        }
    }

}
