// Tabbed Menu
function openMenu(event, menuName) {
    var i, x, tablinks;
    x = document.getElementsByClassName("menu");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";
    }
    
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {  
       tablinks[i].classList.remove("active-tab");  
    }
    
    document.getElementById(menuName).style.display = "block";
    event.currentTarget.classList.add("active-tab");  
  }
  
  // Auto-clicks Appetizers tab when the page loads
  document.getElementById("mainLink").click(); 