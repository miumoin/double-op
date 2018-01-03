<?php
	class module1 {
		function module1() {
			echo "From module 1<br>";
		}

		function module1_home() {
			echo "Hi<br>";
		}

		function module1_method() {
			echo "This is module1 default action";
		}

		function __destruct() {
			echo "Destructing without interference";
		}
	}
?>