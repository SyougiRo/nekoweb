from geopy.geocoders import Nominatim
import sys
import json
import base64
import io
import sys
def func():
    output = {'fu':None,'shi':None,'ku':None}
    input_json = sys.argv[1]
    input_dict = json.loads(input_json)
    geolocator = Nominatim(user_agent="geoapiExercises")
    location = geolocator.reverse(str(input_dict['lat'])+","+str(input_dict['lng']))
    addr = location.address
    val_list = addr.split(',')
    for val in val_list:
        if(val[-1]=='区'):
            output['ku']=val
        elif(val[-1]=='市' or val[-1]=='郡'):
            output['shi']=val
        elif(val[-1]=='府' or val[-1]=='県' or val=='北海道'):
            output['fu']=val
    
    print(json.dumps(output))

if __name__=='__main__':
    sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')
    func()
    #print('test')