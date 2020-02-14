# UCF.R
# user coordinate fetcher
# get user coordinate from Google API and php and create a spatial point object
# ebrahim.jahanshiri@cffresearch.org
# ayman.salama@cffresearch.org
# rgdal without rgeos, in order to have rgeos package we need to install geos-devel on the server

# *****Note: change 1- comment static coordinates 2- uncomment args and 2-path before send to production
ptm <- proc.time()
# centos 1
pathtoscidata <- "/data/sci_data/"
# centos 2
#pathtoscidata <- "/home/data/sci_data/sci_data/"

# check package requirements
.libPaths( c( .libPaths(), "/home/ay_salama/R/x86_64-pc-linux-gnu-library/3.3") )
.libPaths( c( .libPaths(), "/home/ayman3salama/R/x86_64-pc-linux-gnu-library/3.3") )
list.of.packages <- c("raster","rgdal", "maptools","RMySQL","rjson","sp","dplyr","jsonlite", "RCurl")
pckList <- lapply(list.of.packages, require, character.only = TRUE)

# Reading coordinates from the selected point on map
# set the cordinate from input

args <- commandArgs(trailingOnly = TRUE)
lon = args[1]
lat = args[2]
irrFlag = args[3]
coords = cbind(as.numeric(args[1]), as.numeric(args[2]))

# example coordinate 1 Bera
#coords = cbind(102.45386389999999, 3.2705262)
#lon=102.45386389999999
#lat=3.2705262
#irrFlag=0

# example coordinate 2 Brooms barn
# lat = 52.2612682
# lon = 0.5628161
# coords = cbind(lon, lat)
# irrFlag = 0
# 

sp = SpatialPointsDataFrame(coords, data= as.data.frame(1))
crs(sp) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0"


#---------------------------------------------------
#               CLIMATE
#---------------------------------------------------
# UCDF.R
# User Climate data fetcher
# Extracts from climate, rasters based on the coordinate
# ebrahim.jahanshiri@cffresearch.org
# if you have problem with 'rgdal' package, you will need to uninstall and install the package again
# detach("package:rg", unload=TRUE)
# get the raster of the area for temperature and rainfall
raindata = stack()
tempdata = stack()
for (i in c("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12")) {
  temprast = raster(paste(pathtoscidata, "worldClimData/WC2/wc2.0_30s_tavg_",i,".tif",sep=""));
  rainrast = raster(paste(pathtoscidata, "worldClimData/WC2/wc2.0_30s_prec_",i,".tif",sep=""));
  crs(temprast) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0";
  crs(rainrast) = "+proj=longlat +datum=WGS84 +no_defs +ellps=WGS84 +towgs84=0,0,0";
  raindata = addLayer(raindata, rainrast);
  tempdata = addLayer(tempdata, temprast);
}
names(tempdata) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
names(raindata) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")

# user selected temperature and rainfall data
utemp <- as.numeric(data.frame(extract(tempdata, sp)))
urain <- as.numeric(data.frame(extract(raindata, sp)))
print(utemp)
print(urain)

#utemp <- as.numeric(utemp)
#urain <- as.numeric(urain)

#--------------- soil APi
# get the soil data from soilgrids server
out <- NULL
# construct the uri
uri = paste("https://rest.soilgrids.org/query?lon=",lon,"&lat=",lat,"&attributes=CLYPPT,SLTPPT,SNDPPT,PHIHOX,BDRICM", sep="")
# get the URI to json directly
try(ret <- rjson::fromJSON(RCurl::getURL(uri)))
if (exists('ret')){
  if(!class(.Last.value)[1]=="try-error" & !length(ret$properties)==0){
    try(out[[1]] <- data.frame(ret$properties),silent = T)
    try(out[[1]]$lon <- y@coords[i,1],silent = T)
    try(out[[1]]$lat <- y@coords[i,2],silent = T)
  } else {
    try(out[[1]] <- data.frame(lon=y@coords[i,1], lat=y@coords[i,2]),silent = T)
  }
}
## bind all elements together:
out <- as.data.frame(plyr::rbind.fill(out))
#out
# #--------------- SOIL data from server

if (is.null(out)){

## getting the soil

# for global
# for global
phdata = stack()
sandata = stack()
claydata = stack()

ph = NULL
clay = NULL
sand = NULL

for (i in 1:7) phdata = addLayer(phdata, raster(paste(pathtoscidata,"soilgrids/PHIHOX_M_sl",  i, "_250m.tif", sep = "")))
for (i in 1:7) claydata = addLayer(claydata, raster(paste(pathtoscidata,"soilgrids/CLYPPT_M_sl",  i, "_250m.tif", sep = "")))
for (i in 1:7) sandata = addLayer(sandata, raster(paste(pathtoscidata,"soilgrids/SNDPPT_M_sl",  i, "_250m.tif", sep = "")))
depthdata = raster(paste(pathtoscidata,"soilgrids/BDRICM_M_250m.tif", sep = ""))

#
# for (i in 1:7) phdata = addLayer(phdata, raster(paste(pathtoscidata, "soilgrids/PHIHOX_SG_", "GLB", "_LYR",  i, "_20km.tif", sep = "")))
# for (i in 1:7) claydata = addLayer(claydata, raster(paste(pathtoscidata, "/soilgrids/CLYPPT_SG_", "GLB", "_LYR",  i, "_20km.tif", sep = "")))
# for (i in 1:7) sandata = addLayer(sandata, raster(paste(pathtoscidata, "soilgrids/SNDPPT_SG_", "GLB", "_LYR",  i, "_20km.tif", sep = "")))
# depthdata = raster(paste(pathtoscidata,"soilgrids/BDRICM.sG_", "GLB", "_20km.tif", sep = ""))


for (i in 1:7){
  ph = cbind(ph, as.numeric(extract(phdata[[i]], sp)))
  clay = cbind(clay, as.numeric(extract(claydata[[i]], sp)))
  sand = cbind(sand, as.numeric(extract(sandata[[i]], sp)))
}
BDRICM.BDRICM_M = as.numeric(extract(depthdata, sp))

colnames(ph) <- c("PHIHOX.M.sl1","PHIHOX.M.sl2","PHIHOX.M.sl3","PHIHOX.M.sl4","PHIHOX.M.sl5","PHIHOX.M.sl6", "PHIHOX.M.sl7")
colnames(clay) <- c("CLYPPT.M.sl1","CLYPPT.M.sl2","CLYPPT.M.sl3","CLYPPT.M.sl4","CLYPPT.M.sl5","CLYPPT.M.sl6", "CLYPPT.M.sl7")
colnames(sand) <- c("SNDPPT.M.sl1","SNDPPT.M.sl2","SNDPPT.M.sl3","SNDPPT.M.sl4","SNDPPT.M.sl5","SNDPPT.M.sl6", "SNDPPT.M.sl7")
#names(BDRICM.M) <- "BDRICM.BDRICM_M"


out <- cbind(ph, clay, sand, BDRICM.BDRICM_M)

}



#---------------------------------------------------
#             CROP DATA from DB
#---------------------------------------------------
# Connecting to MySQL:
#   Once the RMySQL library is installed create a database connection object.
mydb = dbConnect(MySQL(), user='root', password='yuna2UtR', dbname='cropbase_v_4_2', host='127.0.0.1')

# Running Queries:
#   Queries can be run using the dbSendQuery function.
rs = dbSendQuery(mydb, 'select a.cropid,c.name_var_lndrce,
                 a.rainfall_optimal_max,a.rainfall_optimal_min,
                 a.rainfall_absolute_max,a.rainfall_absolute_min,
                 a.temperature_optimal_max,a.temperature_optimal_min,
                 a.temperature_absolute_max,a.temperature_absolute_min,
                 b.period_between_harvest_min,b.period_between_harvest_max,
                 
                 a.soil_depth_optimal_deep,
                 a.soil_depth_optimal_medium,
                 a.soil_depth_optimal_low,
                 
                 #a.soil_depth_absolute_deep,
                 #a.soil_depth_absolute_medium,
                 #a.soil_depth_absolute_low,
                 
                 a.soil_ph_optimal_max,
                 a.soil_ph_optimal_min,
                 
                 a.soil_ph_absolute_max,
                 a.soil_ph_absolute_min,
                 
                 a.soil_texture_optimal_heavy,
                 a.soil_texture_optimal_medium, 
                 a.soil_texture_optimal_light
                 
                 #a.soil_texture_absolute_high, 
                 #a.soil_texture_absolute_moderate, 
                 #a.soil_texture_absolute_low 
                 
                 
                 from 
                 agro_agroecology a, agro_crop_season b , crop_taxonomy c 
                 
                 where 
                 a.cropid=b.cropid and b.cropid=c.cropid 
                 
                 and a.temperature_absolute_min is not null 
                 and a.temperature_absolute_max is not null 
                 and a.temperature_optimal_min is not null 
                 and a.temperature_optimal_max is not null 
                 
                 and a.rainfall_absolute_min is not null
                 and a.rainfall_absolute_max is not null
                 and a.rainfall_optimal_min is not null 
                 and a.rainfall_optimal_max is not null 
                 
                 and period_between_harvest_min is not null
                 and period_between_harvest_max is not null
                 
                 and a.soil_depth_optimal_low  is not null
                 and a.soil_depth_optimal_medium  is not null
                 and a.soil_depth_optimal_deep  is not null
                 
                 and a.soil_ph_optimal_max   is not null
                 and a.soil_ph_optimal_min  is not null
                 
                 and a.soil_ph_absolute_max  is not null
                 and a.soil_ph_absolute_min  is not null
                 
                 #and a.soil_texture_absolute_high   is not null
                 #and a.soil_texture_absolute_moderate  is not null
                 #and a.soil_texture_absolute_low       is not null
                 
                 and a.soil_texture_optimal_heavy is not null
                 and a.soil_texture_optimal_medium  is not null
                 and a.soil_texture_optimal_light  is not null
                 ;') 


# Retrieving data from MySQL:
#   To retrieve data from the database we need to save a results set object.
ecology = fetch(rs, n=-1)
# write.csv(ecology, file = "MyData.csv")

# calculate the seasonal suitability for average seasonal temperature for n crops
tecocrop = numeric()
recocrop <- numeric()

seasons = numeric()

phsuits = numeric()
depthsuits = numeric()
txtursuits = numeric()

#totalsoilsuit = numeric()
averagesoilsuit = numeric()

#TCS = data.frame()
#TCSave = data.frame()
TCnorain = data.frame()

for (i in 1:nrow(ecology)){
  season = round ((ecology[i,"period_between_harvest_min"] + ecology[i,"period_between_harvest_max"])/60)
  seasons = append(seasons, season)
  
  tmonsuit = numeric()
  tcropsuit = numeric()
  tcropsuitpren = numeric()
  
  #raindataggreg = numeric()
  #raindatapren = numeric()
  #rainsuit = numeric()  
  
  phsuit = numeric()  
  depthsuit = numeric()
  texturesuit = numeric()
  
  #totalsuit = numeric()
  #totalsuitave = numeric()
  #totalsoilsuit = numeric()
  totalsuitave = numeric()
  
  
  
  for (j in 1:12){
    x = utemp[j]
    tabs_min=ecology[i,"temperature_absolute_min"] 
    topt_min=ecology[i,"temperature_optimal_min"] 
    topt_max=ecology[i,"temperature_optimal_max"] 
    tabs_max=ecology[i,"temperature_absolute_max"]
    if (x < tabs_min) {y = 0}
    if ((x >= tabs_min) & (x < topt_min)) {y = ((x - tabs_min)/(topt_min - tabs_min))}
    if ((x>= topt_min) & (x <topt_max))   {y=1}
    if ((x >= topt_max) & (x <tabs_max))   {y  = 1-( (x - topt_max)/(tabs_max - topt_max))} 
    if (x >= tabs_max) {y=0}
    tmonsuit= append(tmonsuit, as.numeric(y))  #CHAN test2
  }
  #teco = cbind (tabs_min,topt_min,topt_max,tabs_max)
  #tecocrop = rbind(tecocrop, teco)
  names(tmonsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  #assign(paste("tmonsuit",i, sep="") , tmonsuit)
  #}
  
  # control the quality
  # tmonsuits=numeric()
  # for (i in 1:nrow(ecology)){
  #   tmonsuits = rbind(tmonsuits,get(paste("tmonsuit",i,sep="")))
  # }
  # round(tmonsuits, digits =1)
  
  # GETTING THE SEASONS RIGHT 
  # average the temp for that crop to be used for temp suitability
  #for (j in 1:nrow(ecology)){
  
  #tmonsuit <- get(paste("tmonsuit",j, sep=""))
  
  if (season <= 1) {
    tcropsuit = tmonsuit
   # raindataggreg = urain
    
  }
  
  if ((season < 12) & (season > 1)) {
    for (j in 1:(12-(season-1))){
      tcropsuit = append(tcropsuit, min(tmonsuit[j:(j+(season-1))]))
      #raindataggreg = append(raindataggreg, sum(as.numeric(urain[j:(j+(season-1))])))
      
    }
    
    #creating a stack for the months that fall over dec
    tcropsuitpren = c(tmonsuit[(12-(season-2)):12], tmonsuit[1:(season-1)])
    #raindatapren = c(urain[(12-(season-2)):12], urain[1:(season-1)])
    
    # adding the aggreages for the rest of the year
    for (k in 1:(length(tcropsuitpren)-(season-1))){
      tcropsuit = append(tcropsuit, min(tcropsuitpren[k:(k+(season-1))]))
      #raindataggreg = append(raindataggreg, sum(as.numeric(raindatapren[k:(k+(season-1))])))
      
    }
  }
  
  if (season >= 12) {                           #CHAN test2
    # to calcuate for the prennials all layers are the same
    for (j in 1:12){
      tcropsuit = append(tcropsuit, min(tmonsuit))
      #raindataggreg = append(raindataggreg, sum(as.numeric(urain[1:12])))
      
    }
  }
  tcropsuit = tcropsuit[1:12]
  names(tcropsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  #names(raindataggreg) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  
  #assign(paste("tcropsuit",j, sep="") , tcropsuit) 
  #}
  
  # control the quality
  # tcropsuits=numeric()
  # for (i in 1:nrow(ecology)){
  #   tcropsuits = rbind(tcropsuits,get(paste("tcropsuit",i,sep="")))
  #   #print(get(paste("tcropsuit",i,sep="")))
  # }
  # round(tcropsuits, digits = 1)
  
  # Aggregate the rain for each season starting from jan
  
  # For a number of crops from 1 to n, get the season right 
  # aggreate the rain for that crop to be use for rain suitability
  # rseason <- numeric()
  # for (j in 1:nrow(ecology)){
  #   season = round ((ecology[j,"period_between_harvest_min"] + ecology[j,"period_between_harvest_max"])/60)
  #   rseason <- append(rseason, season)
  #   raindataggreg = numeric()
  #   raindatapren = numeric()
  #   
  #   if (season == 0) {
  #     raindataggreg = raindata
  #   }
  #   
  #   if ((season < 12) & (season > 0)) {  #CHAN test2
  #     for (i in 1:(12-(season-1))){
  #       raindataggreg = append(raindataggreg, sum(urain[i:(i+(season-1))]))
  #     }
  #     
  #     #creating a stack for the months that fall over dec
  #     raindatapren = c(urain[(12-(season-2)):12], urain[1:(season-1)])
  #     
  #     # adding the aggreages for the rest of the year
  #     for (i in 1:(length(raindatapren)-(season-1))){
  #       raindataggreg = append(raindataggreg, sum(raindatapren[i:(i+(season-1))]))
  #     }
  #   }
  #   if (season >= 12) {          #CHAN test2
  #     # to calcuate for the prennials all layers are the same
  #     for (i in 1:12){
  #       raindataggreg = append(raindataggreg, sum(urain))
  #     }
  #   }
  #   raindataggreg = raindataggreg[1:12]
  #   names(raindataggreg) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  #   assign(paste("rainaggreg",j, sep="") , raindataggreg) 
  # }
  
  # control the quality
  # rainaggregs=numeric()
  # for (i in 1:nrow(ecology)){
  #   rainaggregs = rbind(rainaggregs,get(paste("rainaggreg",i,sep="")))
  #   #print(get(paste("tcropsuit",i,sep="")))
  # }
  # round(rainaggregs, digits = 1)
  
  
  # calcualte rain suitability
  #for (i in 1:nrow(ecology)){
  #rainsuit = numeric()  
  # for (j in 1:12){
  #   x <- raindataggreg[j]
  #   rabs_min=ecology[i,"rainfall_absolute_min"] 
  #   ropt_min=ecology[i,"rainfall_optimal_min"] 
  #   ropt_max=ecology[i,"rainfall_optimal_max"] 
  #   rabs_max=ecology[i,"rainfall_absolute_max"]
  #   if ( irrFlag == 1 ) {
  #     y=1
  #     if (x >= rabs_max) {y = 0}
  #   } else {
  #     if (x < rabs_min) {y = 0}
  #     if ((x >= rabs_min) & (x < ropt_min)) {y = ((x - rabs_min)/(ropt_min - rabs_min))}
  #     if ((x >= ropt_min) & (x < ropt_max)) {y=1}
  #     if ((x >= ropt_max) & (x < rabs_max)) {y  = (1-( (x - ropt_max)/(rabs_max - ropt_max)))}
  #     if (x >= rabs_max) {y = 0}
  #   }
  #   
  #   rainsuit= append(rainsuit, y)
  # }
  # #reco = cbind (tabs_min,topt_min,topt_max,tabs_max)
  # #recocrop = rbind(tecocrop, reco)
  # names(rainsuit) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  #assign(paste("rcropsuit",i, sep="") , rainsuit)
  #}
  
  # control the quality
  # rainsuits=numeric()
  # for (i in 1:nrow(ecology)){
  #   rainsuits = round(rbind(rainsuits,get(paste("rcropsuit",i,sep=""))))
  # }
  # round(rainsuits, digits = 1)
  
  # calculate total and average climate suitability 
  #for (j in 1:nrow(ecology)){
  
  # temptotcal = as.numeric(get(paste("tcropsuit",j, sep="")))
  # raintotcal = as.numeric(get(paste("rcropsuit",j, sep="")))
  
  # temptotcal = tcropsuit
  # raintotcal = rainsuit
  # 
  # 
  # for (j in 1:12){
  #   
  #   if (temptotcal[j]<0.3){ # | raintotcal[j] <0.3) {
  #     totalsuit = append(totalsuit,0)
  #     totalsuitave = append(totalsuitave, 0)
  #   } else {
  #     totalsuit=append(totalsuit,(temptotcal[j]* raintotcal[j])) 
  #     totalsuitave = append(totalsuitave,mean(c(temptotcal[j], raintotcal[j]))) 
  #   }
  # }
  # 
  
  #assign(paste("totalsuit",j, sep="") , totalsuit) 
  #assign(paste("totalsuitave",j, sep="") , totalsuitave) 
  
  #}
  
  #control the quality
  # for (i in 1:nrow(ecology)){
  #TCS = rbind(TCS,totalsuit*100)
  #}
  
  #for (i in 1:nrow(ecology)){
  #TCSave = rbind(TCSave,totalsuitave*100)
  #}
  
  TCnorain = rbind(TCnorain, tcropsuit*100)
  
  
  #names(TCS) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  #names(TCSave) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  names(TCnorain) <- c("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",  "Oct", "Nov", "Dec")
  
  
  #---------------------------------------------------
  #               SOIL
  #---------------------------------------------------
  
  ########################################################
  # calcualte PH suitability
  ########################################################
  
  #for (k in 1:nrow(ecology)){
  #phsuit = numeric()
  phsuitfun = function(x) {
    y=0
    phabs_min=ecology[i,"soil_ph_absolute_min"] 
    phopt_min=ecology[i,"soil_ph_optimal_min"] 
    phopt_max=ecology[i,"soil_ph_optimal_max"] 
    phabs_max=ecology[i,"soil_ph_absolute_max"]
    if (any(x > phabs_min) & any(x < phopt_min))  {y = round(((x - phabs_min)/(phopt_min - phabs_min))*100)}
    if (any(x > phopt_min) & any(x < phopt_max))  {y  = 100}
    if (any(x > phopt_max) & any(x < phabs_max))  {y  = round((1-( (x - phopt_max)/(phabs_max - phopt_max)))*100)}
    if (any(x < phabs_min) | any(x > phabs_max))  {y = 0}
    return(y)
  }  
  
  if (ecology[i,"soil_depth_optimal_low"] == 1){
    phagg = (1/1200)*(5*(out[1,"PHIHOX.M.sl1"]+out[1,"PHIHOX.M.sl2"])+
                         10*(out[1,"PHIHOX.M.sl2"]+out[1,"PHIHOX.M.sl3"])+
                         15*(out[1,"PHIHOX.M.sl3"]+out[1,"PHIHOX.M.sl4"])+
                         30*(out[1,"PHIHOX.M.sl4"]+out[1,"PHIHOX.M.sl5"]))
  }else {
    if (ecology[i, "soil_depth_optimal_medium"] == 1) {
      phagg = (1/2000)*(5*(out[1,"PHIHOX.M.sl1"]+out[1,"PHIHOX.M.sl2"])+
                           10*(out[1,"PHIHOX.M.sl2"]+out[1,"PHIHOX.M.sl3"])+
                           15*(out[1,"PHIHOX.M.sl3"]+out[1,"PHIHOX.M.sl4"])+
                           30*(out[1,"PHIHOX.M.sl4"]+out[1,"PHIHOX.M.sl5"])+
                           40*(out[1,"PHIHOX.M.sl5"]+out[1,"PHIHOX.M.sl6"]))
    }else {
      phagg = (1/4000)*(5*(out[1,"PHIHOX.M.sl1"]+out[1,"PHIHOX.M.sl2"])+
                           10*(out[1,"PHIHOX.M.sl2"]+out[1,"PHIHOX.M.sl3"])+
                           15*(out[1,"PHIHOX.M.sl3"]+out[1,"PHIHOX.M.sl4"])+
                           30*(out[1,"PHIHOX.M.sl4"]+out[1,"PHIHOX.M.sl5"])+
                           40*(out[1,"PHIHOX.M.sl5"]+out[1,"PHIHOX.M.sl6"])+
                           100*(out[1,"PHIHOX.M.sl6"]+out[1,"PHIHOX.M.sl7"]))
      
    }
  }
  
  phsuit <- lapply(phagg, phsuitfun )
  phsuits = append(phsuits, phsuit)
  #assign(paste("phsuit",k, sep="") , phsuit)
  #}
  
  # control the quality
  # phsuits=numeric()
  # for (i in 1:nrow(ecology)){
  #   phsuits = rbind(phsuits,get(paste("phsuit",i,sep="")))
  # }
  
  ########################################################
  # calcualte depth suitability
  ########################################################
  
  # depthsuit = numeric() 
  #for (k in 1:nrow(ecology)){
  
  depthsuitfun = function(x) {
    optz=10
    if ((x >=0) & (x< 50)) {
      if (ecology[i,"soil_depth_optimal_low"] == 1) {
        optz = 100
      } else {
        optz = 10
      }
    }
    if ((x >= 50) & (x< 150)) {
      if (ecology[i,"soil_depth_optimal_medium"] == 1) {
        optz = 100
      } else {
        optz = 10
      }
    }
    if (x >= 150) {
      if (ecology[i,"soil_depth_optimal_deep"] == 1) {
        optz = 100
      } else {
        optz = 10
      }
    }
    
    return(optz)
  }  
  
  depthsuit <- lapply(out[1,"BDRICM.BDRICM_M"], depthsuitfun )
  depthsuits = append(depthsuits, depthsuit)
  
  #}
  #depthsuit <- as.numeric(depthsuit)
  #names(depthsuit) <- c(sprintf("Depthsuit",seq(1:k)))
  
  ########################################################
  # calculate the soil texture suitability for the selected crops
  ########################################################
  
  #texturesuit = numeric() 
  #for (k in 1:nrow(ecology)){
  
  if (ecology[i,"soil_texture_optimal_heavy"] == 1) {
     if (ecology[i,"soil_depth_optimal_low"] == 1){
      sandagg = (1/120)*(5*(out[1,"SNDPPT.M.sl1"]+out[1,"SNDPPT.M.sl2"])+
                           10*(out[1,"SNDPPT.M.sl2"]+out[1,"SNDPPT.M.sl3"])+
                           15*(out[1,"SNDPPT.M.sl3"]+out[1,"SNDPPT.M.sl4"])+
                           30*(out[1,"SNDPPT.M.sl4"]+out[1,"SNDPPT.M.sl5"]))
    }else {
      if (ecology[i, "soil_depth_optimal_medium"] == 1) {
        sandagg = (1/200)*(5*(out[1,"SNDPPT.M.sl1"]+out[1,"SNDPPT.M.sl2"])+
                             10*(out[1,"SNDPPT.M.sl2"]+out[1,"SNDPPT.M.sl3"])+
                             15*(out[1,"SNDPPT.M.sl3"]+out[1,"SNDPPT.M.sl4"])+
                             30*(out[1,"SNDPPT.M.sl4"]+out[1,"SNDPPT.M.sl5"])+
                             40*(out[1,"SNDPPT.M.sl5"]+out[1,"SNDPPT.M.sl6"]))
      }else {
        sandagg = (1/400)*(5*(out[1,"SNDPPT.M.sl1"]+out[1,"SNDPPT.M.sl2"])+
                             10*(out[1,"SNDPPT.M.sl2"]+out[1,"SNDPPT.M.sl3"])+
                             15*(out[1,"SNDPPT.M.sl3"]+out[1,"SNDPPT.M.sl4"])+
                             30*(out[1,"SNDPPT.M.sl4"]+out[1,"SNDPPT.M.sl5"])+
                             40*(out[1,"SNDPPT.M.sl5"]+out[1,"SNDPPT.M.sl6"])+
                             100*(out[1,"SNDPPT.M.sl6"]+out[1,"SNDPPT.M.sl7"]))
        
      }
    }
    
    if (sandagg >= 65) {
      texturesuit = append(texturesuit, 25)
    }else {
      texturesuit = append(texturesuit, 100)
    }
    
    
  } else {
    if (ecology[i,"soil_texture_optimal_light"] == 1) {
      
      if (ecology[i,"soil_depth_optimal_low"] == 1){
        clayagg = (1/120)*(5*(out[1,"CLYPPT.M.sl1"]+out[1,"CLYPPT.M.sl2"])+
                             10*(out[1,"CLYPPT.M.sl2"]+out[1,"CLYPPT.M.sl3"])+
                             15*(out[1,"CLYPPT.M.sl3"]+out[1,"CLYPPT.M.sl4"])+
                             30*(out[1,"CLYPPT.M.sl4"]+out[1,"CLYPPT.M.sl5"]))
      }else {
        if (ecology[i, "soil_depth_optimal_medium"] == 1) {
          clayagg = (1/200)*(5*(out[1,"CLYPPT.M.sl1"]+out[1,"CLYPPT.M.sl2"])+
                               10*(out[1,"CLYPPT.M.sl2"]+out[1,"CLYPPT.M.sl3"])+
                               15*(out[1,"CLYPPT.M.sl3"]+out[1,"CLYPPT.M.sl4"])+
                               30*(out[1,"CLYPPT.M.sl4"]+out[1,"CLYPPT.M.sl5"])+
                               40*(out[1,"CLYPPT.M.sl5"]+out[1,"CLYPPT.M.sl6"]))
        }else {
          clayagg = (1/400)*(5*(out[1,"CLYPPT.M.sl1"]+out[1,"CLYPPT.M.sl2"])+
                               10*(out[1,"CLYPPT.M.sl2"]+out[1,"CLYPPT.M.sl3"])+
                               15*(out[1,"CLYPPT.M.sl3"]+out[1,"CLYPPT.M.sl4"])+
                               30*(out[1,"CLYPPT.M.sl4"]+out[1,"CLYPPT.M.sl5"])+
                               40*(out[1,"CLYPPT.M.sl5"]+out[1,"CLYPPT.M.sl6"])+
                               100*(out[1,"CLYPPT.M.sl6"]+out[1,"CLYPPT.M.sl7"]))
          
        }
      }
      
      if (clayagg >= 15) {
        texturesuit = append(texturesuit, 25)
      }else {
        texturesuit = append(texturesuit, 100)
      }
    } else {
      
      #if (ecology[k,"soil_texture_optimal_medium"] == 1) {
 
      if (ecology[i,"soil_depth_optimal_low"] == 1){
        sandagg = (1/120)*(5*(out[1,"SNDPPT.M.sl1"]+out[1,"SNDPPT.M.sl2"])+
                             10*(out[1,"SNDPPT.M.sl2"]+out[1,"SNDPPT.M.sl3"])+
                             15*(out[1,"SNDPPT.M.sl3"]+out[1,"SNDPPT.M.sl4"])+
                             30*(out[1,"SNDPPT.M.sl4"]+out[1,"SNDPPT.M.sl5"]))
        
        clayagg = (1/120)*(5*(out[1,"CLYPPT.M.sl1"]+out[1,"CLYPPT.M.sl2"])+
                             10*(out[1,"CLYPPT.M.sl2"]+out[1,"CLYPPT.M.sl3"])+
                             15*(out[1,"CLYPPT.M.sl3"]+out[1,"CLYPPT.M.sl4"])+
                             30*(out[1,"CLYPPT.M.sl4"]+out[1,"CLYPPT.M.sl5"]))
      }else {
        if (ecology[i, "soil_depth_optimal_medium"] == 1) {
          sandagg = (1/200)*(5*(out[1,"SNDPPT.M.sl1"]+out[1,"SNDPPT.M.sl2"])+
                               10*(out[1,"SNDPPT.M.sl2"]+out[1,"SNDPPT.M.sl3"])+
                               15*(out[1,"SNDPPT.M.sl3"]+out[1,"SNDPPT.M.sl4"])+
                               30*(out[1,"SNDPPT.M.sl4"]+out[1,"SNDPPT.M.sl5"])+
                               40*(out[1,"SNDPPT.M.sl5"]+out[1,"SNDPPT.M.sl6"]))
          
          clayagg = (1/200)*(5*(out[1,"CLYPPT.M.sl1"]+out[1,"CLYPPT.M.sl2"])+
                               10*(out[1,"CLYPPT.M.sl2"]+out[1,"CLYPPT.M.sl3"])+
                               15*(out[1,"CLYPPT.M.sl3"]+out[1,"CLYPPT.M.sl4"])+
                               30*(out[1,"CLYPPT.M.sl4"]+out[1,"CLYPPT.M.sl5"])+
                               40*(out[1,"CLYPPT.M.sl5"]+out[1,"CLYPPT.M.sl6"]))
        }else {
          sandagg = (1/400)*(5*(out[1,"SNDPPT.M.sl1"]+out[1,"SNDPPT.M.sl2"])+
                               10*(out[1,"SNDPPT.M.sl2"]+out[1,"SNDPPT.M.sl3"])+
                               15*(out[1,"SNDPPT.M.sl3"]+out[1,"SNDPPT.M.sl4"])+
                               30*(out[1,"SNDPPT.M.sl4"]+out[1,"SNDPPT.M.sl5"])+
                               40*(out[1,"SNDPPT.M.sl5"]+out[1,"SNDPPT.M.sl6"])+
                               100*(out[1,"SNDPPT.M.sl6"]+out[1,"SNDPPT.M.sl7"]))
          
          clayagg = (1/400)*(5*(out[1,"CLYPPT.M.sl1"]+out[1,"CLYPPT.M.sl2"])+
                               10*(out[1,"CLYPPT.M.sl2"]+out[1,"CLYPPT.M.sl3"])+
                               15*(out[1,"CLYPPT.M.sl3"]+out[1,"CLYPPT.M.sl4"])+
                               30*(out[1,"CLYPPT.M.sl4"]+out[1,"CLYPPT.M.sl5"])+
                               40*(out[1,"CLYPPT.M.sl5"]+out[1,"CLYPPT.M.sl6"])+
                               100*(out[1,"CLYPPT.M.sl6"]+out[1,"CLYPPT.M.sl7"]))
          
        }
      }
      
      
      if ((sandagg >= 52) | (clayagg > 27)) {
        texturesuit = append(texturesuit, 25)
      } else {
        texturesuit = append(texturesuit, 100)
      }
    }
    
    
  }
  #}
  
  txtursuit <- as.numeric(texturesuit)
  txtursuits <- append(txtursuits, txtursuit)
  #names(texturesuit) <- c(sprintf("texturesuit",seq(1:k)))
  
  #totalsoilsuit= append (totalsoilsuit,(as.numeric(phsuit) * as.numeric(depthsuit) * as.numeric(txtursuits))/10000)
  averagesoilsuit=append(averagesoilsuit, sum(0.6*as.numeric(phsuit) , 0.2*as.numeric(depthsuit) , 0.2*as.numeric(txtursuit)))
  
  
}
########################################################
# calculate total  suitability 
########################################################
#clim_suit <- cbind(CROP_ID = ecology[,1],TCS)
#clim_suit_ave <- cbind(CROP_ID = ecology[,1],TCSave)
clim_suit_norain <- cbind(CROP_ID = ecology[,1],TCnorain)

# calculate total and average suitability 

#for (k in 1:nrow(ecology)){
# phtotcal = phsuit
# depthtotcal = as.numeric(depthsuit)
# txturtotcal = as.numeric(texturesuit)
#totalsoilsuit= append (totalsoilsuit,(phsuit * depthsuit * txtursuits)/10000)
#averagesoilsuit=append(averagesoilsuit, sum(0.6*phsuit , 0.2*depthsuit , 0.2*txtursuit))
#}

#}

# put total and average total suitability of soil with cropid
# i am using cbind.data.frame instead of cbind to avoid the addition of double quote
#avgTotSoil=cbind.data.frame(averagesoilsuit, totalsoilsuit)
avgTotSoilSuit=cbind.data.frame( cropid = ecology$cropid , averagesoilsuit, name =ecology$name_var_lndrce)

########################################################
# calculate total soil-climate suitability 
########################################################
# **********  note we are now taking ave(tempsuit , rainsuit, phsuit, depthsuit, txtursuit)) instead of ave(tempsuit * rainsuit), phsuit, depthsuit, txtursuit)) and soil elements

# to enable the print of cropid as numeric
options(scipen = 50)
climSoil <- as.data.frame(cbind(clim_suit_norain,avgTotSoilSuit))
# remove cropid and keep CROP_ID
climSoil_ID <- subset(climSoil, select = -c(cropid) )
# print the output
write.csv(climSoil_ID, "")
# } else {
#   # to enable the print of cropid as numeric
#   options(scipen = 50)
#   # climSoil <- as.data.frame(cbind(clim_suit,avgTotSoilSuit))
#   climSoil <- cbind.data.frame(clim_suit,101,101,name =ecology$name_var_lndrce)
#   # remove cropid and keep CROP_ID
#   # climSoil_ID <- subset(climSoil, select = -c(cropid) )
#   # print the output
#   write.csv(climSoil, "")

#}
dbclose <- dbDisconnect(mydb)
