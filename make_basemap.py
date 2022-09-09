import cartopy
import matplotlib.pyplot as plt
from PIL import Image
import os
import uuid
import cartopy.crs as ccrs
import sys
import base64
from io import BytesIO
import json
import numpy as np
import pandas as pd

class mapchart():
    def __init__(self) -> None:
        #self.ax = self.initmap()
        pass

    def initmap(self,lat,lon,z=0.1):
        plt.figure(figsize=(16, 9))
        self.crs = ccrs.AlbersEqualArea(central_longitude=110, central_latitude=30, standard_parallels=(25, 47))
        self.ax = plt.axes(projection=self.crs)
        self.ax.coastlines()
        extent=[lon-z*3,lon+z*3,lat-z,lat+z]
        self.ax.set_extent(extent)

    def make_maker(self,lat,lon,txt="",ms=10):
        mklon,mklat = self.crs.transform_point(lon, lat, ccrs.PlateCarree())
        self.ax.plot(mklon,mklat, marker='o', transform=self.crs, ms=ms)
        if(txt!=""):
            self.ax.text(mklon+500,mklat+500,txt)

    def to_base64(self):
        file_name = str(uuid.uuid4())+'.png'
        plt.savefig(file_name) 
        with Image.open(file_name) as im:
            #im.show()
            img_buffer = BytesIO()
            im.save(img_buffer, format='PNG')
            byte_data = img_buffer.getvalue()
            base64_str = base64.b64encode(byte_data)
            base_str = "data:image/png;base64,"+str(base64_str.decode("utf-8"))
            print(base_str)
        #os.remove(file_name)


def returndata():
    mymap = mapchart()
    datas = json_decode()
    data_addr = pd.DataFrame.from_dict(datas['addr'])

    mymap.initmap(get_center(data_addr['lat']),get_center(data_addr['lon']),float(datas['z']))
    #print(datas['z']==4)
    if(datas['z']==4):
        for index, row in data_addr.iterrows():
            #print(row['lat'], row['lon'])
            mymap.make_maker(float(row['lat']),float(row['lon']),row['count'])
    else:
        for index, row in data_addr.iterrows():
            #print(row['lat'], row['lon'])
            mymap.make_maker(float(row['lat']),float(row['lon']),row['txt'],row['count'])
    mymap.to_base64()

def json_decode():
    file_name = sys.argv[1]
    #file_name = 'testtest'
    with open('./buffer/'+file_name, newline='') as jsonfile:
        data = json.load(jsonfile)
    os.remove('./buffer/'+file_name)

    return data

def get_center(datas):
    #print(len(datas))
    sum_lat = 0
    for data in datas:
        sum_lat += float(data)
    
    return sum_lat/len(datas)


if __name__=='__main__':
    returndata()
    #returndata()

