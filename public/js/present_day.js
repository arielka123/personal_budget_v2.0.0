/**
 * set present date
 */

 var dzisiaj = new Date();
 var dzien = dzisiaj.getDate();
 var miesiac = dzisiaj.getMonth()+1;
 var rok = dzisiaj.getFullYear();
 
 if (miesiac<10) miesiac= "0"+miesiac;
 
 if (dzien<10) dzien ="0"+dzien;

 var today = rok +"-"+ miesiac+ "-"+ dzien ;


 var elem = document.getElementById("today");

if(typeof elem !== 'undefined' && elem !== null){
	elem.value = today; 
	elem.setAttribute("max", today);
}

  




	