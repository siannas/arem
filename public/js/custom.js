const my={
    "fileToBase64": async function(file){
        return new Promise(function(resolve){
            let fileReader = new FileReader();
            let base64 = "";
            fileReader.onload = function (event) {
            base64 = event.target.result;
                    resolve(base64)
            };
        
            fileReader.readAsDataURL(file);
        });
    },
    "b64toBlob": function(b64Data, contentType, sliceSize) {
            contentType = contentType || '';
            sliceSize = sliceSize || 512;

            var byteCharacters = atob(b64Data);
            var byteArrays = [];

            for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                var slice = byteCharacters.slice(offset, offset + sliceSize);

                var byteNumbers = new Array(slice.length);
                for (var i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }

                var byteArray = new Uint8Array(byteNumbers);

                byteArrays.push(byteArray);
            }

        var blob = new Blob(byteArrays, {type: contentType});
        return blob;
    },
    "fileToBase64" : async function(file){
        return new Promise(function(resolve){
            let fileReader = new FileReader();
            let base64 = "";
            fileReader.onload = function (event) {
                base64 = event.target.result;
                    resolve(base64)
            };
        
            fileReader.readAsDataURL(file);
        });
    },      
    "noMoreBigFile": async function(file){
        var name =file.name;
        var head = 'data:image/png;base64,';
        name = name.replace(/[\.]\w+$/,"").trim()+'.jpg';
        ext= name.match(/[\.]\w+$/)[0].substr(1);
        if (file && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
        {
            var converted = await this.fileToBase64(file);
            const canvas = document.createElement("CANVAS");
            const ctx = canvas.getContext('2d');

            ctx.mozImageSmoothingEnabled = true;
            ctx.webkitImageSmoothingEnabled = true;
            ctx.msImageSmoothingEnabled = true;
            ctx.imageSmoothingEnabled = true;
            
            var image = await new Promise(function(resolve,reject){
                var imageRaw = new Image();
                imageRaw.onload = function() {
                    resolve(imageRaw);
                }
                imageRaw.src = converted;
            })

            var imgFileSize=999999;

            var divider=1;
            var bot=15, top=1;
            while( Math.abs(bot-top) > 0.11 ){
                divider = (bot-top)/2+top;

                var nW = image.width/divider;
                var nH = image.height/divider;

                ctx.canvas.width = nW;
                ctx.canvas.height = nH;
                ctx.drawImage(image, 0, 0,nW,nH);
                
                converted = canvas.toDataURL("image/jpeg");
                imgFileSize = Math.round((converted.length - head.length)*3/4);

                if(imgFileSize>100000){
                    top=divider;
                }else{
                    bot=divider;
                }

            }
            let index=converted.indexOf(",");
            converted=converted.substr(index+1);
            return this.b64toBlob(converted, 'image/jpeg');

            // return new Promise(function(resolve){ canvas.toBlob(resolve); }) 
        }
        else
        {
            return false;
        }
    }
}