		<div class="wrapper">
			<footer>
				<div class="container">
					<?php echo primary_footer(); ?>	
				</div>
				<div class="sub-footer">
					<div class="container">
						<?php echo secondary_footer(); ?>
					</div>
				</div>
			</footer>
		</div>
		
		<!-- start: JavaScript-->
		<script src="<?php echo BASE ?>/files/js/tinycolor.js"></script>
		<script src="<?php echo BASE ?>/files/js/pick-a-color-1.2.3.min.js"></script>
		<script>
			$(".pick-a-color").pickAColor();

			$(".pick-a-color").on("change", function () {
			  document.getElementById( $(this).attr('id') ).value = $(this).val();
			});

		</script>
		<!-- end: JavaScript-->
    </body>
</html>
