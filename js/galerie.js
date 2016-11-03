function affCom(id_img)
{
	var id_desc = 'desc_'+id_img;
	if (document.getElementById(id_desc).style.display !== 'inline-block')
	document.getElementById(id_desc).style.display = 'inline-block';
	else
		document.getElementById(id_desc).style.display = 'none';
}