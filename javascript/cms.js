//var subjects=document.getElementsByClassName("sub");
//var page=document.getElementsByClassName("pages");
//console.log(subjects);
//var i=0, duzina=subjects.length;
//console.log(duzina);

//console.log(page);
//subjects[0].onmouseover = function () 
	// {
	//	page[0].style.display="block";	
		
	// };

var selected = document.getElementsByClassName("sel");
console.log(selected);

if(selected[0])
{
	var pages = selected[0].getElementsByClassName("pages");
	pages[0].style.display = "block";
	/*
	var link=pages[0].getElementsByTagName("a");
	if(link[0])
	{
		var redirect = link[0].getAttribute("href");
		window.open(redirect, "_self");
	}
	*/
	
}