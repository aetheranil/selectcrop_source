# YDF.R
# Reported Yield data fetcher
# Fetching reported yield data for n crops
# ebrahim.jahanshiri@cffresearch.org

# check package requirements

list.of.packages <- c()  # maybe this "dplyr" is also needed
new.packages <- list.of.packages[!(list.of.packages %in% installed.packages()[,"Package"])]
if(length(new.packages)) install.packages(new.packages)
lapply(list.of.packages, require, character.only = TRUE)

# GET THE YIELD DATA FOR ALL CROPS
yield <- read.csv("reportedyield.csv") ######coming from the DB to be replaced with Query

# GET THE YILED SUBSET DATA BASED ON THE TOP N CROPS
selid <- read.csv("selected_ids.csv") ###### coming from the php ...

# SUBSET DATA FOR SELECTED CROPS
sel.yield = yield[yield$Crop.ID %in% selid$Crop.ID,] 
#sel.yield = sel.yield [,c("Crop.ID", "reported_yield_mean..t.ha.")]

# WRITE THE DATA OUT
write.csv(yield, "yield_subset.csv")
rm(list = ls())
