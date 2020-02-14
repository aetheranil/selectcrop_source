# PBYE.R
# forms a regression model and finds coeficients and then calculates yield for the user selected points
# ebrahim.jahanshiri@cffresearch.org

# check package requirements
list.of.packages <- c()
new.packages <- list.of.packages[!(list.of.packages %in% installed.packages()[,"Package"])]
if(length(new.packages)) install.packages(new.packages)
lapply(list.of.packages, require, character.only = TRUE)


# GET THE YIELD DATA WITH CROPID 
#yield <- read.csv("yield_subset.csv")
total.yield.based.cs <- read.csv("yTCSR.csv", row.names = 1)
total.user.based.cs <- read.csv("uTCSR.csv", row.names = 1)
sel.yield = total.user.based.cs[total.user.based.cs$CROP_ID %in% total.yield.based.cs$CROP_ID,] 
# sel.yield = total.user.based.cs[total.yield.based.cs$CROP_ID %in% total.user.based.cs$CROP_ID,] 

# FOR THE TOP CROP IN THE TCS LIST, FETCH 3 YIELD DATA AND LOCATIONS

# FOR EACH LOCATION GET A CLIMATE SUITABILITY

coefs <- data.frame()
  for (o in c(levels(factor(total.yield.based.cs$CROP_ID)))){  
  
  # o = c(levels(factor(total.yield.based.cs$CROP_ID)))[1]
  
  sub = subset(total.yield.based.cs, CROP_ID == o)
  
  submean <- rowMeans(sub[,4:15])
  yield = sub[,3]                
  lm <- lm(yield ~  submean -1)
  coefs <- rbind (coefs, cbind(CROP_ID = as.numeric(o), coef = coef(lm)[1]) , make.row.names =F)
  #, coef = coef(lm)[2])
  }

# yield = mean of climae suitability at that location for all the months * regression coeficient
cal.yield <- data.frame()
for (i in 1: nrow(sel.yield)){
  if (all (coefs$CROP_ID == sel.yield$CROP_ID)){
    cal.yield [i,1] =  coefs$CROP_ID[i]
    cal.yield [i,2] =  mean(as.numeric(sel.yield[i,2:13])) * as.numeric(coefs[i,2])  
  }
  }


colnames(cal.yield) <- c("CROP_ID", "Cal.yield")
write.csv(cal.yield, "cal_yield.csv", row.names = F)


#mean(total.yield.based.cs$RYIELD.MEAN)

#sel.yield[1,2:13] <- 100
#mean(as.numeric(sel.yield[1,2:13])) * as.numeric(coefs[1,2])


rm(list = ls())
