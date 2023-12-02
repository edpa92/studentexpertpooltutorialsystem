
<script src="./js/jquery/jquery.min.js"></script>
<script src="./js/bootstrap5.3.2/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="./js/fancyTable.js" ></script>
<script src="https://sdk.videosdk.live/js-sdk/0.0.67/videosdk.js"></script>
<script src="./js/config.js"></script>
<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>
<script>

       	let name="<?=($_SESSION["FullnameSEPTS"]);?>";
    	let nameinsession="<?=$_SESSION["FullnameSEPTS"];?>";
		let idinsstud=<?=(isset($_SESSION["RoleSEPTS"]) && $_SESSION["RoleSEPTS"] == "Instructor"?$_SESSION["EmpIdSEPTS"]:$_SESSION["StudentId"])?>;

</script>
<script src="./js/septsmain.js" ></script>
  </body>
</html>