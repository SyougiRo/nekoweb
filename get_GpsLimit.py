import json
import sys

def cunter_gps_val_erro(gps_val): #調整經緯度在負數時的加減法
    if gps_val >= 0: #在正數時乘上1
        return 1
    else: #在負數時乘上-1
        return -1 

def get_rimit_DD(DD):  #取得經緯度極限值
    from geopy.distance import geodesic
    rimit_m = 6000 #設定した距離
    Latitude,Longitude = DD
    newport_ri = (Latitude,Longitude) #設定中心經緯度
    
    i = 0.004

    while True:
        cleveland_oh = (Latitude-(i*cunter_gps_val_erro(Latitude)), Longitude) #在緯度帶入差值
        m = geodesic(newport_ri, cleveland_oh).meters #計算緯度差的距離
        #print(i,m)
        if m>rimit_m-0.01 and m<rimit_m+0.09: #距離再299.99到300.09之間確定緯度差值
            break
        i += 0.00001*(rimit_m-m) #調整差值
        
    if Latitude+i>90: #緯度大於90時改成90
        Latitude_DD_N = 90
    else:
        Latitude_DD_N = Latitude+i #緯度小於90時改成緯度加差值
    if Latitude-i<-90: #緯度小於-90時改成-90
        Latitude_DD_S = -90 
    else:
        Latitude_DD_S = Latitude-i #緯度大於90時改成緯度減差值
    Latitude_DD_rimit = [m,Latitude_DD_N,Latitude_DD_S]
    
    i = 0.004

    while True:
        cleveland_oh = (Latitude, Longitude-(i*cunter_gps_val_erro(Longitude))) #在經度帶入差值
        m = geodesic(newport_ri, cleveland_oh).meters #計算經度差的距離
        #print(Latitude,Longitude , i,m)
        if m>rimit_m-0.01 and m<rimit_m+0.09: #距離再299.99到300.09之間確定經度差值
            break
        i += 0.00001*(rimit_m-m) #調整差值
    
    if Longitude+i>180: #經度大於180時改成180
        Longitude_DD_E = 180
    else:
        Longitude_DD_E = Longitude+i #經度小於180時改成經度加差值
    if Longitude-i<-180: #經度小於-180時改成-180
        Longitude_DD_W = -180 #經度大於-180時改成經度減差值
    else:
        Longitude_DD_W = Longitude-i #經度大於-180時改成經度減差值
    Longitude_DD_rimit = [m,Longitude_DD_E,Longitude_DD_W]
    return Latitude_DD_rimit,Longitude_DD_rimit #回傳經緯度各自的距離差及兩端的經緯度

def do_print():
    output = {}
    lat = sys.argv[1]
    lng = sys.argv[2]
    #input_dict = json.loads(input_json)
    DD = (float(lat),float(lng))
    limit = get_rimit_DD(DD)
    gps_dict = {
        'lat_km'  : limit[0][0],
        'lat_max' : limit[0][1],
        'lat_min' : limit[0][2],
        'lng_km'  : limit[1][0],
        'lng_max' : limit[1][1],
        'lng_min' : limit[1][2],
        }
    print(json.dumps(gps_dict))

if __name__=="__main__":
    #print(sys.argv)
    do_print()
