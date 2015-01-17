<div id="header">
    <h1>{$title}</h1>
</div>

<div id="imageAlbum" class="contentContainer" >
    {$content}
</div>

<script>
    $(function() {
        $('.popup').swipebox();
        $('#imageAlbum img').unveil();
    });
</script>
