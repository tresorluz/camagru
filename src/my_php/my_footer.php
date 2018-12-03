<footer class="footer">
    <p class="copyright center">© tluzing 2018</p>
</footer>

<?php
if (isset($js_source))
{
    foreach ($js_source as $value){?>
    <script src="<?php
        echo $value;?>">
    </script>
<?php
}
}?>

<script>

var close = document.getElementsByClassName("close");
if (close[0])
{
    close[0].onclick = function(){
        var div = this.parentElement;
        div.remove();
    } 
}        
</script>
</body>
</html>