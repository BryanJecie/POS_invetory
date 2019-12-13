/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
 

document.onkeyup = clickF2;

function clickF2(e)
{
   var KeyID = (window.event) ? event.keyCode : e.keyCode;
        
      if (KeyID === 113) {
        // $('#modal-change-btn').click();
      } 
      else if(KeyID === 120){
        $('#btn-120').click();
      }
      else if(KeyID === 121){
        $('#btn-121').click();
      }
  
    e.preventDefault();

}
 