from geopy.geocoders import Nominatim
import sys
import json

def func():
    output = {}
    input_json = sys.argv[1]
    print(input_json)
    input_dict = json.loads(input_json)
    geolocator = Nominatim(user_agent="geoapiExercises")
    location = geolocator.reverse(str(input_dict['lat'])+","+str(input_dict['lng']))
    addr = location.address
    val_list = addr.split(',')
    for val in val_list:
        if(val[-1]=='区'):
            output['ku']=val
        elif(val[-1]=='市'):
            output['shi']=val
        elif(val[-1]=='府'):
            output['fu']=val
    print(json.dumps(output,ensure_ascii=False))

if __name__=='__main__':
    func()