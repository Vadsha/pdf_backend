<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    {{-- <div style="height:90px ; display: flex; flex-direction:row; background-color:red; margin-bottom:5px" id="output">
    </div>
    <form action="{{ route('fetch') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input class="images" type="file" name="image1" id="image1" style="display: block">
        <input class="images" type="file" name="image2" id="image2" style="display: none">
        <input class="images" type="file" name="image3" id="image3" style="display: none">
        <input class="images" type="file" name="image4" id="image4" style="display: none">

        <button style="margin-top:5px;">click</button>
    </form>

    <script>
        let output = document.querySelector('#output');
        let image1 = document.querySelector('#image1')
        let image2 = document.querySelector('#image2')
        let image3 = document.querySelector('#image3')
        let image4 = document.querySelector('#image4')
        let imagesArray = [];

        function displayImages() {
            let images = ""
            imagesArray.forEach((image, index) => {
                images += `<div class="image">
                    <img style="margin-right:5px" width="80px" height="90px"  src="${URL.createObjectURL(image)}" alt="image">
                  </div>`
            })
            output.innerHTML = images
        }

        image1.addEventListener('change', (event) => {
            imagesArray.push(image1.files[0])
            image1.style.display = 'none';
            image2.style.display = 'block';
            displayImages();
        })
        image2.addEventListener('change', (event) => {
            imagesArray.push(image2.files[0])
            image2.style.display = 'none';
            image3.style.display = 'block';
            displayImages();
        })
        image3.addEventListener('change', (event) => {
            imagesArray.push(image3.files[0])
            image3.style.display = 'none';
            image4.style.display = 'block';
            displayImages();
        })
        image4.addEventListener('change', (event) => {
            imagesArray.push(image4.files[0])
            displayImages();
        })
    </script> --}}
</body>

</html>
