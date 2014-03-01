<h1>{$title}</h1>
<div id="imageAlbum">
    {$content}
</div>

<script>
    $(function() {
        $('div').magnificPopup({
            type: 'image',
            delegate: 'a.popup',
            gallery: {
                enabled: true
            }
        });

       $('#imageAlbum img').unveil();
    });
</script>
