(function (){
    document.getElementById('vendorapproval-table_wrapper').Datatables(
        {
            'onInit': function () {
                vendorApprovalScripts();
            }
        }
    )
})()





const vendorApprovalScripts = () => {
    let vendorApprovalButton = document.querySelector('.approve-vendor')
    vendorApprovalButton.addEventListener('click', function (e) {
        e.preventDefault();
        let id = e.target.dataset.id;
        let status = e.target.dataset.status;
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let url = e.target.dataset.url;
        let data = {
            id: id,
            status: status,
            _token: token
        };
        axios.post(url, data)
            .then(function (response) {
                if (response.data.status == 'success') {
                    toastr.success(response.data.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(function (error) {
                toastr.error(error.message);
            });
    });
}