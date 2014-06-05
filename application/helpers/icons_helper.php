<?php
function getIcon($category){
	switch($category){
		case("Burger Joint"):
		case("Burgers"):
				return "burger.png";
				break;
		case("Bar"):
		case("Sports Bar"):
				return "beer.png";
				break;
		case("Pizza Place"):
		case("Pizza"):
				return "pizza.png";
				break;
		case("Seafood"):
				return "lobster.png";
				break;
                case("Caf?"):
                case("Coffee Shop"):
                                return "coffee.png";
                                break;
		default:
				return "default.png";
	}
}
?>