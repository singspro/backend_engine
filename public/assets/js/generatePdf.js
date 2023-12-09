
let generatePdf={
    data:function(data){
        let x=0;
        let z=data.peserta.length;
        this.page.qty=z/20;
        if(this.page.qty>1){
            this.page.status=true;
        }
        this.header=data.header;
        data.peserta.forEach(element => {
            x++;
            this.peserta.push(element); 
            if(x==20){
                this.page.number++;
                generate(this);
                x=0;
                this.peserta=[];
            } 
        });
        if(this.peserta.length>0){
            this.page.number++;
            generate(this);
        }
        hal=0;
    },
    header:{},
    peserta:[],
    page:{
        number:0,
        qty:0,
        status:false
    }
}

function generate(data){

let x =new jsPDF({
    orientation:'l',
    unit:'mm',
    format:'a4'
});
x.rect(10,10,277,190);
x.line(10,27,287,27);
x.line(10,28.7,287,28.7);
x.line(10,60.8,287,60.8);
x.line(10,62.5,287,62.5);
x.line(54.7,10,54.7,27);
x.line(224,10,224,27);
x.setFillColor(0,176,80); // warna hijau
x.rect(11.6,64,273.8,13.2,'F'); //header table hijau
x.rect(11.6,64,273.8,101.2);

//Horizontal content line
let gapLine=4.4;
let gapStart=77.2;
let lineQty=20;
x.line(11.6,gapStart,285.4,gapStart);
for (let index = 0; index < lineQty; index++) {
    gapStart=gapStart+gapLine;
    x.line(11.6,gapStart,285.4,gapStart);
}
x.line(212.4,68.7,265.4,68.7);
x.line(177.3,191.2,224,191.2);
x.line(235.1,191.2,277.9,191.2);

//Dash line
let drawLine={
    dashlength:1,
    dashGap:1,
    x1:60,
    y1:34,
    x2:285.4,
    y2:34,
    repeat:function(){
        let data=Math.round((this.x2 - this.x1)/(this.dashlength+this.dashGap))
    
        return data;
    },
    draw:function(){
          let i=0;
        let startLine=this.x1;
        do {
            x.line(startLine,this.y1,startLine+this.dashlength,this.y2);
            startLine=startLine+this.dashlength+this.dashGap;
            i++;
        } while (i<this.repeat());            
    
    }
}
drawLine.y1=34;
drawLine.y2=34;
drawLine.draw();

drawLine.y1=38.2;
drawLine.y2=38.2;
drawLine.draw();

drawLine.y1=42.5;
drawLine.y2=42.5;
drawLine.draw();

drawLine.y1=46.7;
drawLine.y2=46.7;
drawLine.draw();

drawLine.y1=51;
drawLine.y2=51;
drawLine.draw();

drawLine.y1=55.2;
drawLine.y2=55.2;
drawLine.draw();

drawLine.y1=59.4;
drawLine.y2=59.4;
drawLine.draw();

//Vertical content line
x.line(18.8,64,18.8,165.2);
x.line(51.2,64,51.2,165.2);
x.line(96.7,64,96.7,165.2);
x.line(137,64,137,165.2);
x.line(212.4,64,212.4,165.2);
x.line(232.4,68.7,232.4,165.2);
x.line(243.4,68.7,243.4,165.2);
x.line(254.4,68.7,254.4,165.2);
x.line(265.4,64,265.4,165.2);


//Text content
x.setFontSize(13);
x.setFont('arial','bold','normal');
x.text('FORM PENILAIAN HASIL PELATIHAN',148.5,18.7,'center');

x.setFontSize(10);
x.setFont('arial','normal','normal');
x.text('No. Document ',224.9,13.9);
x.text(': F-MAC-IMS-16-006 ',248,13.9);
x.text('No. Revisi ',224.9,13.9+5.7);
x.text(': 1.0  ',248,13.9+5.7);
x.text('Tanggal ',224.9,13.9+5.7+5.7);
x.text(': 01-11-2020 ',248,13.9+5.7+5.7);

x.text('Kode Pelatihan',11.6,33);
x.text(`: ${data.header.kode}`,60,33);

x.text('Nama Pelatihan',11.6,37.2);
x.text(`: ${data.header.judul}`,60,37.2);

x.text('Durasi',11.6,41.5);
x.text(`: ${data.header.durasi}`,60,41.5);

x.text('Tanggal Pelatihan',11.6,45.7);
x.text(`: ${data.header.tanggal}`,60,45.7);

x.text('Tanggal Assessment',11.6,50);
x.text(`: ${data.header.tanggalAssessment}`,60,50);

x.text('Lokasi',11.6,54.2);
x.text(`: ${data.header.lokasi}`,60,54.2);

x.text('Nama Instruktur',11.6,58.4);
x.text(`: ${data.header.instructor}`,60,58.4);

//Horizontal content line
let l=data.peserta.length;
let gapPesertaContent=4.4;
let gapPesertaStart=76.5;
let linePesertaQty=20;
for (let index = 0; index < linePesertaQty; index++) {
    gapPesertaStart=gapPesertaStart+gapPesertaContent;
    x.setFontSize(8);
    if(index<l){
        x.text(String(index+1),15,gapPesertaStart,'center');
        x.text((data.peserta[index].minePermit===null)?'-':data.peserta[index].minePermit,20,gapPesertaStart);
        x.text(data.peserta[index].nama,53,gapPesertaStart);
        x.text(data.peserta[index].perusahaan,116.6,gapPesertaStart,'center');
        x.text((data.peserta[index].posisi===null)?'-':String(data.peserta[index].posisi),175,gapPesertaStart,'center');
        x.text((data.peserta[index].preTest===null)?'-':String(data.peserta[index].preTest),222,gapPesertaStart,'center');
        x.text((data.peserta[index].postTest===null)?'-':String(data.peserta[index].postTest),238,gapPesertaStart,'center');
        x.text((data.peserta[index].practice===null)?'-':String(data.peserta[index].practice),249,gapPesertaStart,'center');
        x.text((data.peserta[index].hasil===null)?'-':String(data.peserta[index].hasil),260,gapPesertaStart,'center');
        x.text((data.peserta[index].keterangan===null)?'-':String(data.peserta[index].keterangan),275.2,gapPesertaStart,'center');
    }else{
        x.text(String(index+1),15,gapPesertaStart,'center');
        x.text('-',20,gapPesertaStart);
        x.text('-',53,gapPesertaStart);
        x.text('-',116.6,gapPesertaStart,'center');
        x.text('-',175,gapPesertaStart,'center');
        x.text('-',222,gapPesertaStart,'center');
        x.text('-',238,gapPesertaStart,'center');
        x.text('-',249,gapPesertaStart,'center');
        x.text('-',260,gapPesertaStart,'center');
        x.text('-',275.2,gapPesertaStart,'center');
    }
}

//table header
x.setFontSize(10);
x.setFont('arial','bold','normal');
x.text('No.','12.6','72.7');
x.text('No Mine Permit','22','72.7');
x.text('Nama Karyawan','58.2','72.7');
x.text('Perusahaan','104.5','72.7');
x.text('Posisi','170.3','72.7');
x.text('Nilai Pelatihan','227.1','67.6');
x.text('Pre Test','216.7','72');
x.text('(*)','221.9','76');
x.text('PAC','234.2','74.1');
x.text('Hasil','255.6','72');
x.text('(**)','256.9','76');
x.text('WAC','244.6','74.1');
x.text('Keterangan','265.6','72.7');


//Foooter
x.setFontSize(10);
x.setFont('arial','normal','normal');
x.text('Disiapkan Oleh,',178.4,172.1);
x.text(`Nama : ${data.header.instructor}` ,178.7,190.3);
x.text(`Tanggal : ${data.header.tanggal}`,178.3,194.3);
x.text('Disetujui Oleh,',235.4,172.1);
x.text('Nama :',236.2,190.3);
x.text('Tanggal :',235.8,194.3);

x.text('Keterangan :',19.1,172);
x.text('(*) Apabila tidak tersedia/tidak dilakukan',28.9,177.2);
x.text('(**) CO (Competent) - Bila Nilai Pelatihan > 75',28.9,182.2);
x.line(94.5,182.2,96.5,182.2);
x.text('(**) NYC (Not Yet Competent) - Bila Nilai Pelatihan < 75',28.9,187);



let filename;
if(data.page.status){
    filename=`HASIL PELATIHAN ${data.header.judul} ${data.header.tanggal} HAL ${data.page.number}`;
}else{
    filename=`HASIL PELATIHAN ${data.header.judul} ${data.header.tanggal}`;
}


    

    let img=new Image();
        img.src='assets/img/ami.jpg';
    img.onload = function () {
        x.addImage(img, 'jpg', 16, 12, 26, 14); 
        x.save(filename);
    }  
    
  
}

