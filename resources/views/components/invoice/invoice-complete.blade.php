<div class="modal animated zoomIn" id="complete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Completed !</h3>
                <p class="mb-3">Are you printed this invoice? Once completed, you can't show it in this page.</p>
                <input class="d-none" id="completeID"/>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="complete-modal-close" class="btn bg-gradient-success" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemComplete()" type="button" id="confirmDelete" class="btn bg-gradient-danger" >Complete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     async  function  itemComplete(){
            let id=document.getElementById('completeID').value;
            document.getElementById('complete-modal-close').click();
            showLoader();
            let res=await axios.post("/invoice-complete",{inv_id:id})
            hideLoader();
            if(res.data===1){
                successToast("Request completed")
                await getList();
            }
            else{
                errorToast("Request fail!")
            }
     }
</script>
