function customer(){
    window.location.href="/customer/home.html";
    window.event.returnValue=false;
}
function modify(){
  alert("update success");
  window.location.href="/customer/myhouse.html";
    window.event.returnValue=false;

}
function staff(){
    window.location.href="About.html";
    window.event.returnValue=false;
    
}
function deleteme(){

    var mymessage=confirm("Are you sure you want to permanently delete this account?");
	if(mymessage==true)
	{
		alert("Delete Account Success , login out now !");
        window.location.href="/index.html";
        window.event.returnValue=false;
	}
	else if(mymessage==false)
	{
		
	}
}
function modfiy(){

    var mymessage=confirm("Are you sure you want to modify this account?");
	if(mymessage==true)
	{
        window.location.href="./modify.html";
        window.event.returnValue=false;
	}
	else if(mymessage==false)
	{
		
	}
}
function reg(){

    var mymessage=confirm("Are you sure you modify this account");
	if(mymessage==true)
	{
        window.location.href="./myhouse.html";
        window.event.returnValue=false;
	}
	else if(mymessage==false)
	{
		window.location.href="./myhouse.html";
		window.event.returnValue=false;
	}
}
var currentTab = 0; 
showTab(currentTab); 

function showTab(n) {
 
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
 
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  
  fixStepIndicator(n)
}

function nextPrev(n) {
 
  var x = document.getElementsByClassName("tab");
 
  if (n == 1 && !validateForm()) return false;
 
  x[currentTab].style.display = "none";
  
  currentTab = currentTab + n;
  
  if (currentTab >= x.length) {
  
    document.getElementById("regForm").submit();
    return false;
  }
  
  showTab(currentTab);
}

function validateForm() {

  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  
  for (i = 0; i < y.length; i++) {
   
    if (y[i].value == "") {
   
      y[i].className += " invalid";
 
      valid = false;
    }
  }
 
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; 
}

function fixStepIndicator(n) {
  
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }

  x[n].className += " active";
}
function createbills(){
	var mymessage=confirm("Are you sure you want to create this bills");
	if(mymessage==true)
	{
		alert("create success!");
        window.location.href="./myhouse.html";
        window.event.returnValue=false;
	}
	else if(mymessage==false)
	{
		
	}
    

}