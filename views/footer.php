
<script src="./js/jquery/jquery.min.js"></script>
<script src="./js/bootstrap5.3.2/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="./js/fancyTable.js" ></script>
<script>

       	let name="<?=($_SESSION["FullnameSEPTS"]);?>";
    	let nameinsession="<?=$_SESSION["FullnameSEPTS"];?>";
		let idinsstud=<?=(isset($_SESSION["RoleSEPTS"]) && $_SESSION["RoleSEPTS"] == "Instructor"?$_SESSION["EmpIdSEPTS"]:$_SESSION["StudentId"])?>;

</script>
<script src="./js/septsmain.js" ></script>
  </body>
</html>