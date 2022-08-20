import base64
from io import BytesIO
from PIL import Image
import sys
import os

def pillow_to_base64(image):
    img_buffer = BytesIO()
    if(image.mode=='JPEG'):
        format = 'JPEG'
    
    else:
        format = 'PNG'
    
    image.save(img_buffer, format=format)
    byte_data = img_buffer.getvalue()
    base64_str = base64.b64encode(byte_data)
    return base64_str

def resize_base64():
    file_name = sys.argv[1]

    with open(file_name,mode='r') as f:
        input_json = f.read()
    #print(input_json[0:100])
    img_base = input_json.split(',')[1]
    image = base64.b64decode(img_base)
    image = BytesIO(image)
    image = Image.open(image)
    h,w = image.size
    r = w/h
    #print(image.mode)
    image = image.resize((640,int(640*r)))
    base_str = str(input_json.split(',')[0])+str(pillow_to_base64(image).decode("utf-8"))
    
    with open(file_name,mode='w') as f:
        f.write(base_str)
        
    print(base_str)


if __name__=="__main__":
    resize_base64()
