# extract.R
# Extracts from climate, soil and yield rasters based on given coordinates
# ebrahim.jahanshiri@cffresearch.org

# Reading coordinates from the selected point on map
args <- commandArgs(trailingOnly = TRUE)
print(args[1])
print(args[2])

# Creating a spatial point object from the given coordinates
require(rgdal)
coords = cbind(as.numeric(args[1]), as.numeric(args[2]))
#coords = cbind(102.45386389999999, 3.2705262)
sp = SpatialPoints(coords)

# List all rasters for climate & extract data from them 
require(raster)
#ptm <- proc.time()
cnums <- numeric()
clist <- list.files(paste(getwd(),"/Rworkshop/rasters/",sep=""), pattern = "c")
for (i in 1:length(clist)) {
  testrast <- raster(paste(getwd(),"/Rworkshop/rasters/",clist[i],sep=""))
  cnums <- append(as.numeric(extract(testrast, sp)), cnums)
}
#proc.time() - ptm

# List all rasters for soil
snums <- numeric()
slist <- list.files(paste(getwd(),"/Rworkshop/rasters/",sep=""), pattern = "s")
for (i in 1:length(slist)) {
  testrast <- raster(paste(getwd(),"/Rworkshop/rasters/",slist[i],sep=""))
  snums <- append(as.numeric(extract(testrast, sp)), snums)
}

# List all rasters for yield


# List all rasters for income


# Output all data
#write.csv(cbind(clist,round(cnums)), "result.csv")
cropidc <- substr(clist, start=2, stop=12)
cropids <- substr(slist, start=2, stop=12)


x=cbind(cropidc, round(cnums))
y=cbind(cropids, round(snums))
cbind(x,y)
paste(cropidc [1],"climate:", cnums[1], "/n", "soil:", snums[1], sep=" ")
#cbind(cropids,  round(cnums), round(snums))

