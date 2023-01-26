document.addEventListener('DOMContentLoaded', function(){ 
    const rows = Array.from(document.querySelectorAll('.data-row'));
    
    function slideOut(row) {
      row.classList.add('slide-out');
    }
    
    function slideIn(row, index) {
      setTimeout(function() {
        row.classList.remove('slide-out');
      }, (index + 5) * 200);  
    }
    
    rows.forEach(slideOut);
    
    rows.forEach(slideIn);
}, false);
