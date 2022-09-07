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

    def make_maker(self,lat,lon,txt='',ms=10):
        mklon,mklat = self.crs.transform_point(lon, lat, ccrs.PlateCarree())
        self.ax.plot(mklon,mklat, marker='o', transform=self.crs, ms=ms)
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
        os.remove(file_name)


def returndata():
    mymap = mapchart()
    datas = json_decode()
    mymap.initmap(get_lat_center(datas),get_lon_center(datas))
    for data in datas:
        #print(data)
        mymap.make_maker(float(data['lat']),float(data['lon']),data['txt'],int(data['count']))
    mymap.to_base64()

def json_decode():
    file_name = sys.argv[1]
    #file_name = 'testtest'
    with open('./buffer/'+file_name, newline='') as jsonfile:
        data = json.load(jsonfile)
    os.remove('./buffer/'+file_name)

    return data

def get_lat_center(datas):
    #print(len(datas))
    sum_lat = 0
    for data in datas:
        sum_lat += float(data['lat'])
    
    return sum_lat/len(datas)

def get_lon_center(datas):
    sum_lon = 0
    for data in datas:
        sum_lon += float(data['lon'])
    
    return sum_lon/len(datas)

if __name__=='__main__':
    returndata()
    #returndata()

