var video=document.querySelector("#videoElement");
var sticker1=document.querySelector("#sticker1");
var sticker2=document.querySelector("#sticker2");
var sticker3=document.querySelector("#sticker3");
var sticker4=document.querySelector("#sticker4");
var stickerName=document.querySelector("#sticker-name");
var imageView = document.querySelector("#imageView");
var imageChoose = document.querySelector("#image-picker");


sticker1.addEventListener('click', (event)=>{stickerName.value = "sticker1.png";alert("First sticker.");});
sticker2.addEventListener('click', (event)=>{stickerName.value = "sticker2.png";alert("Second sticker.");});
sticker3.addEventListener('click', (event)=>{stickerName.value = "sticker3.png";alert("Third sticker.");});
sticker4.addEventListener('click', (event)=>{stickerName.value = "sticker4.png";alert("Fourth sticker.");});

navigator.getUserMedia=navigator.getUserMedia||navigator.
webkitGetUsermedia||navigator.mozGetUserMedia||navigator.
msGetUserMedia||navigator.ogetUserMedia;
if (navigator.getUserMedia) {
    navigator.getUserMedia({video:true},handleVideo,videoError);
}
function handleVideo(stream){
    video.srcObject=(stream)
}
function videoError(e){
    
}
var capturedPhoto = document.querySelector("#take-photo");
capturedPhoto.addEventListener('click', (event)=>
{
    const canvas = document.querySelector("#canvas");
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, 340, 250);
    context.drawImage(imageView, 0, 0, 340, 250);
    saveImage(canvas.toDataURL('image/png'));
});
imageChoose.addEventListener('change', (event)=>{
    var reader = new FileReader;
    reader.addEventListener('load', (event)=>{
        imageView.src = reader.result; 
    });
    reader.readAsDataURL(imageChoose.files[0]);
 });
function saveImage(url)
{
    var param = "";
    var http = new XMLHttpRequest();
    if (stickerName.value)
        param = "image-url="+url+"&image="+stickerName.value;
    else
        param = "image-url="+url;
    http.onreadystatechange = function()
    {
       if (http.readyState === 4) { 
           if (http.status === 200) { 
           }
       }
    };
    http.open('POST', "uploads/save_image.php", true);
    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    http.send(param);
}
function loadImages(url)
{
    var http = new XMLHttpRequest();
    var param = "image-url="+url;
    http.onreadystatechange = function()
    {
       if (http.readyState === 4) { 
           if (http.status === 200) { 
           }
       }
    };
    http.open('POST', "uploads/save_image.php", true);
    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    http.send(param);
}
function removeImages(event)
{
    if (event.button == 2)
    {
        var answer = window.confirm("Want to remove the image?")
        if (answer) 
        {
            var imageData = event.srcElement.src;
            var filename = imageData.replace(/^.*[\\\/]/, '');
            var http = new XMLHttpRequest();
            var param = "remove=yes&image="+filename;
            http.onreadystatechange = function()
            {
            if (http.readyState === 4) {
                if (http.status === 200) 
                {
                }
            }
            };
            http.open('POST', "uploads/remove_pic.php", true);
            http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            http.send(param);
        }
    }
}