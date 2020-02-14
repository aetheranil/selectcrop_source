<?php

$KBS_All_Info_Tables=array(
	"Info_KBS_General",
	"Info_KBS_General_Usage",
	"Info_KBS_Type",
	"Info_KBS_Growth_Habit",
	"Info_KBS_Growth_Cycle",
	"Info_KBS_Agronomic_Practices",
	"Info_KBS_Fertiliser",
	"Info_KBS_Pathology",
	"Info_KBS_Agroecology",
	"Info_KBS_Resist_Tolerance",
	"Info_KBS_Cropping_System",
	"Info_KBS_Season",
	"Info_KBS_Food_Parts_Used",
	"Info_KBS_Nutrient_Composition",
	"Info_KBS_Nutrient_Minerals",
	"Info_KBS_Nutrient_Vitamins",
	"Info_KBS_Optimal_Handling_Fresh_produce",
	"Info_KBS_Cooling_Method",
	"Info_KBS_Food_Preparation",
	"Info_KBS_Stroage_Form",
	"Info_KBS_Storage_Life",
	"Info_KBS_Biomass_Uses",
	"Info_KBS_Biomass_Parts_Used",
	"Info_KBS_Biomass_Proximate",
	"Info_KBS_Biomass_Ulitmate",
	"Info_KBS_Biomass_Thermogravimetric",
	"Info_KBS_Biomass_Output",
	"Info_KBS_Subsidy",
	"Info_KBS_Price",
	"Info_KBS_Water_Source",
	"Info_KBS_Infrastructure",
	"Info_KBS_Market",
	"Info_KBS_Human"
);

$KBS_All_Tables=array(
		"KBS_General",
		"KBS_General_Usage",
		"KBS_Type",
		"KBS_Growth_Habit",
		"KBS_Growth_Cycle",
		"KBS_Agronomic_Practices",
		"KBS_Fertiliser",
		"KBS_Pathology",
		"KBS_Agroecology",
		"KBS_Resist_Tolerance",
		"KBS_Cropping_System",
		"KBS_Season",
		"KBS_Food_Parts_Used",
		"KBS_Nutrient_Composition",
		"KBS_Nutrient_Minerals",
		"KBS_Nutrient_Vitamins",
		"KBS_Optimal_Handling_Fresh_produce",
		"KBS_Cooling_Method",
		"KBS_Food_Preparation",
		"KBS_Stroage_Form",
		"KBS_Storage_Life",
		"KBS_Biomass_Uses",
		"KBS_Biomass_Parts_Used",
		"KBS_Biomass_Proximate",
		"KBS_Biomass_Ulitmate",
		"KBS_Biomass_Thermogravimetric",
		"KBS_Biomass_Output",
		"KBS_Subsidy",
		"KBS_Price",
		"KBS_Water_Source",
		"KBS_Infrastructure",
		"KBS_Market",
		"KBS_Human"
);

$KBS_General_col=array(
		"cropID",
		"name",
		"sci_name",
		"fam_name",
		"variety",
		"landrace",
		"plant", "kbs_gen_others");

$KBS_General_Usage_col = array(
		"cropID",
		"gen_use_aroma",
		"gen_use_bever",
		"gen_use_bioma",
		"gen_use_const",
		"gen_use_food",
		"gen_use_forag",
		"gen_use_herb",
		"gen_use_indus",
		"gen_use_medic",
		"gen_use_ornam",
		"gen_use_relig",
		"gen_use_stimu",
		"kbs_gen_usg_others"
);

$KBS_Type_col = array(
		"cropID",
		"type_cereals",
		"type_forest_tree",
		"type_fruit",
		"type_gras",
		"type_herb",
		"type_legume",
		"type_nut",
		"type_pseudocereal",
		"type_pulse",
		"type_root",
		"type_tuber",
		"type_vegetable",
		"kbs_type_others"

);
$KBS_Growth_Habit_col = array(
		"cropID",
		"growth_habit_forb",
		"growth_habit_graminoid",
		"growth_habit_liana",
		"growth_habit_lichenous",
		"growth_habit_nonvascular",
		"growth_habit_shrub",
		"growth_habit_subshrub",
		"growth_habit_tree",
		"growth_habit_vine",
		"kbs_gh_others"
);
$KBS_Growth_Cycle_col = array(
		"cropID",
		"growth_cycle_annual",
		"growth_cycle_biannual",
		"growth_cycle_prennial",
		"growth_cycle_other",
		"kbs_gc_others"
);


$KBS_Agronomic_Practices_col = array(
		"cropID",
		"day_irrig_amoung_max",
		"day_irrig_amoung_mean",
		"day_irrig_amoung_min",
		"day_irrig_amoung_unit",
		"irrig_amount_max",
		"irrig_amount_mean",
		"irrig_amount_min",
		"irrig_amount_unit",
		"freq_Irrigation_max",
		"freq_Irrigation_mean",
		"freq_Irrigation_min",
		"freq_Irrigation_Unit",
		"irrig_drip",
		"irrig_other",
		"irrig_sprinkler",
		"irrig_subsurface",
		"irrig_surface",
		"row_Spac_Inter_row_max",
		"row_Spac_Inter_row_mean",
		"row_Spac_Inter_row_min",
		"row_Spac_Inter_row_unit",
		"plant_dir_seeding",
		"plant_transplanting",
		"plant_veg_propag",
		"row_spac_within_row_max",
		"row_spac_within_row_mean",
		"row_spac_within_row_min",
		"row_spac_within_row_unit",
		"tillage_plough",
		"tillage_cultivar",
		"tillage_rolling",
		"tillage_harrow",
		"seed_rate_max",
		"seed_rate_mean",
		"seed_rate_min",
		"seed_rate_unit",
		"seed_type_comrcl",
		"seed_type_hybrid_fx",
		"seed_type_bvkcrs_bcxfx",
		"seed_type_selected",
		"seed_type_purified",
		"seed_type_ril",
		"seed_type_nil",
		"seed_type_other",
		"kbs_agropract_others"
		);

$KBS_Fertiliser_col=Array(
		"cropID",
		"in_organ_fertiliser_max",
		"in_organ_fertiliser_mean",
		"in_organ_fertiliser_min",
		"in_organ_fertiliser_unit",
		"nitro_fertiliser_max",
		"nitro_fertiliser_mean",
		"nitro_fertiliser_min",
		"nitro_fertiliser_unit",
		"organ_Fertiliser_max",
		"organ_Fertiliser_mean",
		"organ_Fertiliser_min",
		"organ_Fertiliser_unit",
		"phosp_fertiliser_max",
		"phosp_fertiliser_mean",
		"phosp_fertiliser_min",
		"phosp_fertiliser_unit",
		"potas_fertiliser_max",
		"potas_fertiliser_mean",
		"potas_fertiliser_min",
		"potas_fertiliser_unit",
		"kbs_fert_others"
		);
$KBS_Pathology_col=Array(
		"cropID",
		"disease_contr_agronomic",
		"disease_contr_biological",
		"disease_contr_chemical",
		"disease_contr_integrated",
		"disease_manage",
		"pest_contr_agronomic",
		"pest_contr_biological",
		"pest_contr_chemical",
		"pest_contr_integrated",
		"pest_manage",
		"weed_contr_agronomic",
		"weed_contr_biological",
		"weed_contr_integrated",
		"weed_contr_chemical",
		"weed_manage",
		"kbs_patho_others"
		);
$KBS_Agroecology_col=Array(
		"cropID",
		"agr_ecol_zone_A",
		"agr_ecol_zone_B",
		"agr_ecol_zone_C",
		"agr_ecol_zone_D",
		"agr_ecol_zone_E",
		"agr_ecol_altitude_max",
		"agr_ecol_altitude_mean",
		"agr_ecol_altitude_min",
		"agr_ecol_altitude_unit",
		"agr_ecol_aspect_max",
		"agr_ecol_aspect_mean",
		"agr_ecol_aspect_min",
		"agr_ecol_aspect_unit",
		"agr_ecol_ph_max",
		"agr_ecol_ph_mean",
		"agr_ecol_ph_min",
		"agr_ecol_ph_unit",
		"agr_ecol_rain_max",
		"agr_ecol_rain_mean",
		"agr_ecol_rain_min",
		"agr_ecol_rain_unit",
		"agr_ecol_slope_max",
		"agr_ecol_slope_mean",
		"agr_ecol_slope_min",
		"agr_ecol_slope_unit",
		"agr_ecol_temp_max",
		"agr_ecol_temp_mean",
		"agr_ecol_temp_min",
		"agr_ecol_temp_unit",
		"agr_ecol_clay_max",
		"agr_ecol_clay_mean",
		"agr_ecol_clay_min",
		"agr_ecol_clay_unit",
		"agr_ecol_sand_max",
		"agr_ecol_sand_mean",
		"agr_ecol_sand_min",
		"agr_ecol_sand_unit",
		"agr_ecol_silt_max",
		"agr_ecol_silt_mean",
		"agr_ecol_silt_min",
		"agr_ecol_silt_unit",
		"kbs_agroecol_others"
		);
$KBS_Resist_Tolerance_col=Array(
		"cropID",
		"toler_disease",
		"toler_drought",
		"toler_extreme_alkal",
		"toler_extreme_acid",
		"toler_heat",
		"toler_frost",
		"toler_infertile_soil",
		"toler_pest",
		"toler_salinity",
		"toler_shade",
		"toler_waterlogging",
		"toler_weed",
		"kbs_resisttoler_others"
		);
$KBS_Cropping_System_col=Array(
		"cropID",
		"crop_system_intercrop",
		"crop_system_monocrop",
		"crop_system_mixed",
		"crop_system_rotate",
		"crop_system_alley",
		"crop_system_multitier",
		"kbs_cropsys_others");
$KBS_Season_col=Array(
		"cropID",
		"season_1_year",
		"season_2_year",
		"season_3_year",
		"season_all_year",
		"season_irrigated",
		"season_irrig_rainfed",
		"season_length_min",
		"season_length_max",
		"season_length_mean",
		"season_length_unit",
		"season_rainfed",
		"kbs_season_others"
		);
$KBS_Food_Parts_Used_col=Array(
		"cropID",
		"food_part_bark",
		"food_part_bulb",
		"food_part_flower",
		"food_part_fruits",
		"food_part_grain",
		"food_part_leaf",
		"food_part_root",
		"food_part_seed",
		"food_part_stem",
		"food_part_tuber",
		"food_part_whole",
		"food_part_wood",
		"kbs_foodpart_others"
		);

$KBS_Nutrient_Composition_col=Array(
		"cropID",
		"compos_ash_min",
		"compos_ash_max",
		"compos_ash_mean",
		"compos_ash_unit",
		"compos_cho_min",
		"compos_cho_max",
		"compos_cho_mean",
		"compos_cho_unit",
		"compos_energy_min",
		"compos_energy_max",
		"compos_energy_mean",
		"compos_energy_unit",
		"compos_fibre_min",
		"compos_fibre_max",
		"compos_fibre_mean",
		"compos_fibre_unit",
		"compos_protein_min",
		"compos_protein_max",
		"compos_protein_mean",
		"compos_protein_unit",
		"compos_sat_fat_min",
		"compos_sat_fat_max",
		"compos_sat_fat_mean",
		"compos_sat_fat_unit",
		"compos_unsat_fat_min",
		"compos_unsat_fat_max",
		"compos_unsat_fat_mean",
		"compos_unsat_fat_unit",
		"compos_water_min",
		"compos_water_max",
		"compos_water_mean",
		"compos_water_unit",
		"Moisture_content_min",
		"Moisture_content_max",
		"Moisture_content_mean",
		"Moisture_content_unit",
		"kbs_nutricomp_others"
		);
$KBS_Nutrient_Minerals_col=Array(
		"cropID",
		"miner_ca_min",
		"miner_ca_max",
		"miner_ca_mean",
		"miner_ca_unit",
		"miner_cu_min",
		"miner_cu_max",
		"miner_cu_mean",
		"miner_cu_unit",
		"miner_fe_min",
		"miner_fe_max",
		"miner_fe_mean",
		"miner_fe_unit",
		"miner_mg_min",
		"miner_mg_max",
		"miner_mg_mean",
		"miner_mg_unit",
		"miner_mn_min",
		"miner_mn_max",
		"miner_mn_mean",
		"miner_mn_unit",
		"miner_na_min",
		"miner_na_max",
		"miner_na_mean",
		"miner_na_unit",
		"miner_p_min",
		"miner_p_max",
		"miner_p_mean",
		"miner_p_unit",
		"miner_k_min",
		"miner_k_max",
		"miner_k_mean",
		"miner_k_unit",
		"miner_zn_min",
		"miner_zn_max",
		"miner_zn_mean",
		"miner_zn_unit",
		"kbs_nutriminer_others"
		);
$KBS_Nutrient_Vitamins_col=Array(
		"cropID",
		"vitam_caro_min",
		"vitam_caro_max",
		"vitam_caro_mean",
		"vitam_caro_unit",
		"vatam_niac_min",
		"vatam_niac_max",
		"vatam_niac_mean",
		"vatam_niac_unit",
		"vitam_retinol_min",
		"vitam_retinol_max",
		"vitam_retinol_mean",
		"vitam_retinol_unit",
		"vitam_a_min",
		"vitam_a_max",
		"vitam_a_mean",
		"vitam_a_unit",
		"vitam_b1_min",
		"vitam_b1_max",
		"vitam_b1_mean",
		"vitam_b1_unit",
		"vitam_b2_min",
		"vitam_b2_max",
		"vitam_b2_mean",
		"vitam_b2_unit",
		"vitam_c_min",
		"vitam_c_max",
		"vitam_c_mean",
		"vitam_c_unit",
		"kbs_nutrivit_others"
		);
$KBS_Optimal_Handling_Fresh_produce_col=Array(
		"cropID",
		"ethylene_product_rate_min",
		"ethylene_product_rate_max",
		"ethylene_product_rate_mean",
		"ethylene_product_rate_unit",
		"ethylene_sensi_high",
		"ethylene_sensi_low",
		"ethylene_sensi_medium",
		"highest_freez_temp_min",
		"highest_freez_temp_max",
		"highest_freez_temp_mean",
		"highest_freez_temp_unit",
		"opt_reltv_humidity_min",
		"opt_reltv_humidity_max",
		"opt_reltv_humidity_mean",
		"opt_reltv_humidity_unit",
		"opt_stor_temperature_min",
		"opt_stor_temperature_max",
		"opt_stor_temperature_mean",
		"opt_stor_temperature_unit",
		"stor_life_min",
		"stor_life_max",
		"stor_life_mean",
		"stor_life_unit",
		"kbs_optimhandle_others"
		);
$KBS_Cooling_Method_col=Array(
		"cropID",
		"forced_air_evaporative",
		"forced_ari ",
		"hydrocooling",
		"package_icing",
		"room_cooling",
		"vacuum_cooling",
		"water_spray_vacuum",
		"kbs_coolingmeth_others"
		);
$KBS_Food_Preparation_col=Array(
		"cropID",
		"prep_bake",
		"prep_boiled",
		"prep_complementary",
		"prep_cooked",
		"prep_garnish",
		"prep_grilled",
		"prep_ground",
		"prep_raw_garnish",
		"prep_staple",
		"prep_steamed",
		"kbs_foodprep_others"
		);
$KBS_Stroage_Form_col=Array(
		"cropID",
		"prep_dried",
		"prep_grinded",
		"prep_whole",
		"kbs_storgeform_others"
		);
$KBS_Storage_Life_col=Array(
		"cropID",
		"stor_life_long",
		"stor_life_med",
		"stor_life_short",
		"kbs_storagelife_others"
		);
$KBS_Biomass_Uses_col=Array(					
		"cropID",
		"biomass_bio_ageant",
		"biomass_energy",
		"biomass_heat",
		"biomass_reagent",
		"kbs_biomuse_others"
		);
$KBS_Biomass_Parts_Used_col=Array(
		"cropID",
		"biomass_part_bark",
		"biomass_part_bulb",
		"biomass_part_flower",
		"biomass_part_fruits",
		"biomass_part_grain",
		"biomass_part_leaf",
		"biomass_part_root",
		"biomass_part_seed",
		"biomass_part_stem",
		"biomass_part_tuber",
		"biomass_part_whole",
		"biomass_part_wood",
		"kbs_biompart_others"
		);
$KBS_Biomass_Proximate_col=Array(
		"cropID",
		"biomass_ash_min",
		"biomass_ash_max",
		"biomass_ash_mean",
		"biomass_ash_unit",
		"biomass_fixed_carbon_min",
		"biomass_fixed_carbon_max",
		"biomass_fixed_carbon_mean",
		"biomass_fixed_carbon_unit",
		"biomass_proximate_moisture_min",
		"biomass_proximate_moisture_max",
		"biomass_proximate_moisture_mean",
		"biomass_proximate_moisture_unit",
		"biomass_volatile_matter_min",
		"biomass_volatile_matter_max",
		"biomass_volatile_matter_mean",
		"biomass_volatile_matter_unit",
		"kbs_biompart_others"
		);
$KBS_Biomass_Ulitmate_col=Array(
		"cropID",
		"biomass_carbon_min",
		"biomass_carbon_max",
		"biomass_carbon_mean",
		"biomass_carbon_unit",
		"biomass_hydrogen_min",
		"biomass_hydrogen_max",
		"biomass_hydrogen_mean",
		"biomass_hydrogen_unit",
		"biomass_nitrogen_min",
		"biomass_nitrogen_max",
		"biomass_nitrogen_mean",
		"biomass_nitrogen_unit",
		"biomass_oxygen_min",
		"biomass_oxygen_max",
		"biomass_oxygen_mean",
		"biomass_oxygen_unit",
		"biomass_sulphur_min",
		"biomass_sulphur_max",
		"biomass_sulphur_mean",
		"biomass_sulphur_unit",
		"kbs_biomultimate_others"
		);
$KBS_Biomass_Thermogravimetric_col=Array(
		"cropID",
		"biomass_cellulose_min",
		"biomass_cellulose_max",
		"biomass_cellulose_mean",
		"biomass_cellulose_unit",
		"biomass_hemicellulose_min",
		"biomass_hemicellulose_max",
		"biomass_hemicellulose_mean",
		"biomass_hemicellulose_unit",
		"biomass_lignin_min",
		"biomass_lignin_max",
		"biomass_lignin_mean",
		"biomass_lignin_unit",
		"biomass_thermo_moisture_min",
		"biomass_thermo_moisture_max",
		"biomass_thermo_moisture_mean",
		"biomass_thermo_moisture_unit",
		"biomass_oxygen_bomb_hhv_min",
		"biomass_oxygen_bomb_hhv_max",
		"biomass_oxygen_bomb_hhv_mean",
		"biomass_oxygen_bomb_hhv_unit",
		"kbs_biomthermograv_others"
		);
$KBS_Biomass_Output_col=Array(
		"cropID",
		"biomass_power_output_min",
		"biomass_power_output_max",
		"biomass_power_output_mean",
		"biomass_power_output_unit",
		"biomass_total_min",
		"biomass_total_max",
		"biomass_total_mean",
		"biomass_total_unit",
		"kbs_biomoupt_others"
		);
$KBS_Subsidy_col=Array(
		"cropID",
		"subsidy_fertiliser",
		"subsidy_seed",
		"subsidy_produce",
		"kbs_subsid_others"
		);
$KBS_Price_col=Array(
		"cropID",
		"income_ratio_max",
		"income_ratio_mean",
		"income_ratio_min",
		"income_ratio_unit",
		"price_seasonal_max",
		"price_seasonal_mean",
		"price_seasonal_min",
		"price_seasonal_unit",
		"kbs_price_others"
		);
$KBS_Water_Source_col=Array(
		"cropID",
		"water_source_borewell",
		"water_source_artesian",
		"water_source_river",
		"water_source_rainfed",
		"kbs_watersource_others"
		);
$KBS_Infrastructure_col=Array(
		"cropID",
		"electricity_good",
		"electricity_moderate",
		"electricity_poor",
		"market_access_moderate",
		"market_access_poor",
		"market_acess_good",
		"road_good",
		"road_poor",
		"road_moderate",
		"water_access_good",
		"water_access_moderate",
		"water_access_poor",
		"kbs_infrastruct_others"
		);
$KBS_Market_col=Array(
		"cropID",
		"produce_sale_formal",
		"produce_sale_informal",
		"seed_source_formal",
		"seed_source_informal",
		"kbs_market_others"
		);
$KBS_Human_col=Array(
		"cropID",
		"demography_alternate_income",
		"demography_educated",
		"land_size_max",
		"land_size_mean",
		"land_size_min",
		"land_size_unit",
		"demography_kids",
		"distnace_from_home_max",
		"distnace_from_home_mean",
		"distnace_from_home_min",
		"distnace_from_home_unit",
		"demography_married",
		"land_prep_men",
		"land_prep_women",
		"land_prep_others",
		"planting_men",
		"planting_women",
		"planting_others",
		"irrigation_men",
		"irrigation_women",
		"irrigation_others",
		"fertiliser_men",
		"fertiliser_women",
		"fertiliser_others",
		"food_prep_men",
		"food_prep_women",
		"food_prep_others",
		"market_selling_men",
		"market_selling_women",
		"market_selling_others",
		"household_size_small",
		"household_size_medium",
		"household_size_large",
		"land_owned",
		"land_rented",
		"land_other",
		"technology_hand",
		"technology_machinary",
		"knolwedge_family",
		"knolwedge_extension",
		"knolwedge_person_experiment",
		"knolwedge_other",
		"kbs_human_others"
		);




		
		?>