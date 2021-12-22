
$(document).ready(function() {
    $("input:text").focus(function() { $(this).select(); } );
});

function SelectAllText()
{
	$("input:text").focus(function() { $(this).select(); } );
}