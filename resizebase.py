import base64
from io import BytesIO
from PIL import Image
import sys
import os

def pillow_to_base64(image):
    img_buffer = BytesIO()
    
    image.save(img_buffer, format='JPEG')
    byte_data = img_buffer.getvalue()
    base64_str = base64.b64encode(byte_data)
    return base64_str

def resize_base64():
    file_name = sys.argv[1]

    with open('./buffer/'+file_name,mode='r') as f:
        input_json = f.read()
    
    img_base = input_json.split(',')[1]
    image = base64.b64decode(img_base)
    image = BytesIO(image)
    image = Image.open(image)
    h,w = image.size
    r = w/h
    
    image = image.resize((640,int(640*r)))
    base_str = "data:image/jpeg;base64,"+str(pillow_to_base64(image).decode("utf-8"))
        
    print(base_str)
    os.remove('./buffer/'+file_name)


if __name__=="__main__":
    resize_base64()
