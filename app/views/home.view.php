<h1>Home page view</h1>

<div>
    <img class="source_img" src="<?=$file?>">
    <div class="source"></div>
</div>
<div>
    <img class="thumbnail_img" src="<?=$thumbnail?>">
    <div class="thumbnail"></div>
</div>

<script>
    window.onload =function() {
        let img = document.querySelector(".source_img");
        let thumb = document.querySelector(".thumbnail_img)");
    
        document.querySelector(".source").innerHTML = `width: ${img.width}, height: ${img.height}`;
        document.querySelector(".thumbnail").innerHTML = `width: ${thumb.width}, height: ${thumb.height}`;
    }
</script>