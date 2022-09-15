var base = location.protocol+'//'+location.host;
var route = document.getElementsByName('routeName')[0].getAttribute('content');
const http = new XMLHttpRequest();
const csrfToken = document.getElementsByName('csrf-token')[0].getAttribute('content');
document.addEventListener('DOMContentLoaded', function(){
    
    var btn_search = document.getElementById('btn_search');
    var form_search = document.getElementById('form_search');
    var category = document.getElementById('category');
    if (btn_search){
        btn_search.addEventListener('click', function(e){
            e.preventDefault();
            if (form_search.style.display === 'block'){
                form_search.style.display = 'none';
            } else {
                form_search.style.display = 'block';
            }
             
        });
    }
    if(route == "product_add"){
        setSubCategoriesToProducts();
    }   

    if(route == "product_edit"){
        setSubCategoriesToProducts();
        var btn_product_file_image = document.getElementById('btn_product_file_image');
    var product_file_image = document.getElementById('product_file_image');
    btn_product_file_image.addEventListener('click', function(){
        
        product_file_image.click();
    }, false);

    product_file_image.addEventListener('change', function(){
        document.getElementById('form_product_gallery').submit();
    });

    }

    route_active = document.getElementsByClassName('lk-'+route)[0].classList.add('active');

    btn_deleted=document.getElementsByClassName('btn-deleted');
    for(i=0;i< btn_deleted.length; i++){
        btn_deleted[i].addEventListener('click', delete_object);
    }

    if(category){
        
        category.addEventListener('change', setSubCategoriesToProducts);
    }

    function delete_object(e){
        e.preventDefault();
        var object = this.getAttribute('data-object');
        var action = this.getAttribute('data-action');
        var path = this.getAttribute('data-path');
        var url = base + '/' + path + '/' + object + '/' + action;
        if(action == "delete"){
            mdalert({title: '¿Estas seguro de eliminar este producto?', type: 'delete', msg: 'Una vez eliminado pasará a la papelera de reciclaje!', actions: JSON.stringify([{url: url, name: 'Si, eliminar', type: 'danger' }]) });
        }
        if(action == "restore"){
        mdalert({title: '¿Estas seguro de restaurar este producto?', type: 'restore', msg: 'Una vez restaurado este volverá a ser visible', actions: JSON.stringify([{url: url, name: 'Si, restaurar', type: 'success' }]) });
        }
        /*
        
        var text,msg1,msg2,icon;
        if(action == "delete"){
            text = "Una vez eliminado pasará a la papelera de reciclaje!";
            msg1 = "Eliminado!";
            msg2 = "El producto fue eliminado correctamente.";
            icon = "warning";
        }

        if (action == "restore"){
                text = "Una vez restaurado este volverá a ser visible";
                msg1 = "Restaurado";
                msg2 = "El producto fue restaurado correctamente"; 
                icon = "question";
        }
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                msg1,
                msg2,
                'success'
              )
              window.location.href = url;
            }
          });
        */
    }

    function setSubCategoriesToProducts(){
        parent_id = category.value;
        subcategory_actual = document.getElementById('subcategory_actual').value;
        select = document.getElementById('subcategory');
        select.innerHTML ="";
        var url = base + '/admin/md/api/load/subcategories/'+parent_id;
        http.open('GET', url, true);
        http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        http.send();
        http.onreadystatechange = function(){        
            if(this.readyState==4 && this.status== 200){
                var data = this.responseText;            
                data = JSON.parse(data);             
                data.forEach(function(element,index){
                    if(subcategory_actual == element.id ){
                        select.innerHTML += "<option value=\""+element.id+"\" selected>"+element.name+"</option>";
                    } else {                    
                        select.innerHTML += "<option value=\""+element.id+"\">"+element.name+"</option>";
                    }
                });
            }
        }
    }
    
});