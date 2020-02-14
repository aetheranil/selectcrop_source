# YCDF.R
# Yield Climate data fetcher
# Extracts from climate, rasters based on the subste yield coordinates
# ebrahim.jahanshiri@cffresearch.org
# if you have problem with 'rgdal' package, you will need to uninstall and install the package again
# detach("package:rg", unload=TRUE)
# install.packages("rgdal", lib="/usr/lib64/R/library")

# CHECK FOR EXISTANCE OF PACKAGES
list.of.packages <- c("rgdal", "maptools", "raster")
new.packages <- list.of.packages[!(list.of.packages %in% installed.packages()[,"Package"])]
if(length(new.packages)) install.packages(new.packages)
lapply(list.of.packages, require, character.only = TRUE)


# ASSUME THAT yieldsp OBJECT IS ALREADY LOADED or load it from file 
if (!exists("yieldsp")){yieldsp = readShapePoints("yieldsp.shp", 
                                                  CRS("+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0"))} 

# get the raster of the area for temperature and rainfall
#require(raster)

if (!exists("tempdata") | !exists("raindata")){
raindata = stack()
tempdata = stack()
#zone = 29
for (i in 1:12) {
  temprast = raster(paste("/data/sci_data/worldClimData/tmean",i,"_global.tif",sep=""));  
  rainrast = raster(paste("/data/sci_data/worldClimData/prec",i,"_global.tif",sep="")); 
  #temprast = mask(crop(temprast, extent(boundary)), boundary);
  #rainrast = mask(crop(rainrast, extent(boundary)), boundary);
  crs(temprast) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0";
  crs(rainrast) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0";
  #  assign (paste("tmean", i, district, country, sep=""), temprast) # in case of write out
  #  assign (paste("rain", i, district, country, sep=""), rainrast) # in case of write out
  raindata = addLayer(raindata, rainrast)
  tempdata = addLayer(tempdata, temprast)
}
names(tempdata) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
names(raindata) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
}

# user selected temperature and rainfall data  ,NAME = yieldsp$Name_Var_L
ytemp <- data.frame(CROP_ID = yieldsp$Crop_ID, 
                    NAME = yieldsp$Name_Var_L,
                    RYIELD.MEAN = yieldsp$repyieldme,
                    extract(tempdata, yieldsp))
yrain <- data.frame(CROP_ID = yieldsp$Crop_ID,
                    NAME = yieldsp$Name_Var_L,
                    RYIELD.MEAN = yieldsp$repyieldme,
                    extract(raindata, yieldsp))

# REMOVE ROWS THAT CONTAIN NA, WRITING TO DISK

write.table(ytemp[complete.cases(ytemp),], "yield_temp_monthly.txt")
write.table(yrain[complete.cases(yrain),], "yield_rain_monthly.txt")
