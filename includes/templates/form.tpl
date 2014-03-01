<h1>Sign in</h1>
<div id="form">
    <form id="login" method="post" action="{$action}">
        <label for="password">Password</label>
        <input type="password" required="requited" id="password" name="password">
        <input type="submit" value="sign in">
    </form>
    <p class="errors">{$errors}</p>
</div>

<script>
    $(function() {
        $('div').magnificPopup({
            type: 'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });

       $('#imageAlbum img').unveil();
    });
</script>
