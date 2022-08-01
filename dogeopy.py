from geopy.geocoders import Nominatim
import sys
import json

def func():
    output = {}
    geolocator = Nominatim(user_agent="geoapiExercises")
    location = geolocator.reverse(sys.argv[1]+","+sys.argv[2])
    addr = location.address
    val_list = addr.split(',')
    for val in val_list:
        if(val[-1]=='区'):
            output['ku']=val
        elif(val[-1]=='市'):
            output['shi']=val
        elif(val[-1]=='府'):
            output['fu']=val
    print(json.dumps(output))

if __name__=='__main__':
    func()