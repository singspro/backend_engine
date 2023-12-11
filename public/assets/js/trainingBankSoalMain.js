function showLinkBtn(th){
    let a= new ModalLink('oiuooiu','modalLink','mmmm',th.getAttribute('data-link'),th.getAttribute('data-expired'))
    a.show();
}

function ModalLink(id,anchor, qrId,link,expired){
    let modalHtml=`<div class="modal fade" id="${id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"     aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Link Soal</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <div class='row'>
                            <div class='col-lg-12'>
                                <div class='col-lg-12 mb-3'>
                                <h5>Silahkan scan qr code di bawah ini untuk mendapatkan link soal. Selamat mengerjakan</h5>
                                <div id=${qrId}>
                                </div>
                                </div>
                                <div class='col-lg-12 mb-3'>
                                <a href=${link} target="_blank">${link}</a>
                                </div>
                                <div class='col-lg-12 mb-3'>
                                <h5>Link tersebut akan expired pada : ${dt(expired)} pukul : ${tm(expired)}   WIB</h5>
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Got it</button>
                            </div>
                        </div>
                        </div>
                    </div>`;
    function dt(dateStr){
        let a=new Date(dateStr);
        var datestring = ("0" + a.getDate()).slice(-2) + "-" + ("0"+(a.getMonth()+1)).slice(-2) + "-" + a.getFullYear();
        return datestring;
    }
    function tm(dateStr){
        let a=new Date(dateStr);
        var datestring =("0" + a.getHours()).slice(-2) + ":" + ("0" + a.getMinutes()).slice(-2);
        return datestring;
    }
    this.show=function(){
        let a=document.getElementById(anchor);
        a.innerHTML=modalHtml;
        let qr=new QRCode(document.getElementById(qrId),link);
        $('#'+id).modal('show');

    }
}