(function(){document.getElementById("vendorapproval-table_wrapper").Datatables({onInit:function(){c()}})})();const c=()=>{document.querySelector(".approve-vendor").addEventListener("click",function(e){e.preventDefault();let a=e.target.dataset.id,o=e.target.dataset.status,n=document.querySelector('meta[name="csrf-token"]').getAttribute("content"),r=e.target.dataset.url,s={id:a,status:o,_token:n};axios.post(r,s).then(function(t){t.data.status=="success"?(toastr.success(t.data.message),setTimeout(function(){window.location.reload()},1e3)):toastr.error(t.data.message)}).catch(function(t){toastr.error(t.message)})})};