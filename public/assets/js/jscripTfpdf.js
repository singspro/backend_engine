function rwa(dtr){
        var urut=0;

        var a1=dtr.psrtTaf[0];
        var aa= dtr.psrtTaf[1];
        var bb= dtr.psrtTaf[0];
        var cc= dtr.psrtTaf[2];
        var dd= dtr.psrtTaf[3];
        var ee= dtr.psrtTaf[4];
        var cnt=a1.length;
        var loop=Math.ceil(cnt/12);
        var i=0;
        var hal=0;
        
       do{
            var ht=0;
            var a= new Array();
            var b= new Array();
            var c= new Array();
            var d= new Array();
            var e= new Array();
            if((cnt-12)<1){ht=cnt;}else{ht=12; cnt=cnt-12;}
            for(x=0;x<ht;x++){
                a[x]=aa[urut];
                b[x]=bb[urut];
                c[x]=cc[urut];
                d[x]=dd[urut];
                e[x]=ee[urut];
                urut++;
            
            }
            i++;
            hal++;
            var id=[a,b,c,d,e];
            generateTaf(dtr,id,hal); 
        }while(i<loop);

}

function generateTaf(x,id,hal) {
    var img=new Image();
    var tgl;
    var namaTaf;
    img.src='assets/img/sadaro.jpg';
    if(x.dataTaf[3]==x.dataTaf[4]){
        tgl=x.dataTaf[3];
    }else{
        tgl=x.dataTaf[3]+" - "+x.dataTaf[4];
    }
    if(hal>1){
        namaTaf='TAF TRAINING '+x.dataTaf[1]+' TANGGAL '+tgl+' HAL '+hal+'.pdf';
    }else{
        namaTaf='TAF TRAINING '+x.dataTaf[1]+' TANGGAL '+tgl+'.pdf';
    }
    var doc = new jsPDF();
    doc.setFontSize(7);
    doc.text(175, 9, 'Halaman : 1/1');
    doc.text(175, 15, 'Form No. SFC/09/F-004');

    doc.setFontSize(7);
    doc.text(15, 50, 'No.');
    doc.text(30, 50,': '+x.dataTaf[0]);
    doc.text(80, 50, 'Date : '+x.dataTaf[5]);
    doc.text(115, 50, 'Application Reference : ATC/NON ATC *)  ATP/NON ATP *)');


    doc.text(15, 58, 'To');
    doc.text(30, 58,': '+x.dataTaf[12]);

    doc.text(15, 66, 'From');
    doc.text(30, 66,': '+x.dataTaf[13]);

    doc.text(15, 74, 'Subject');
    doc.text(30, 74,': '+x.dataTaf[14]);

    doc.text(15, 82,'Dengan ini, kami mohon persetujuan dan pendaftaran untuk mengikuti Pelatihan / Kursus / Seminar / Lokakarya atas nama Pekerja di bawah ini :');

    doc.text(15,172,'Adapun Pelatihan / Kursus / Seminar / Lokakarya *) yang akan diikuti karyawan tersebut, adalah :');
    doc.text(15,180,'Nama Pelatihan / Kursus / Seminar / Lokakarya');doc.text(90,180,': '+x.dataTaf[1]);
    doc.text(15,186,'Lokasi/Tanggal Pelaksanaan'); doc.text(90,186,': '+x.dataTaf[6]+', '+tgl);
    doc.text(15,192,'Penyelenggara');doc.text(90,192,': '+x.dataTaf[2]);
    doc.text(15,198,'Biaya'); doc.text(90,198,': '+x.dataTaf[7]);
    doc.text(15,208,'Terlampir bersama ini, brosur/informasi mengenai pelatihan / kursus / seminar / lokakarya* tersebut.');
    doc.text(15,216,'MACO   , '+x.dataTaf[5]);
    doc.text(15,224,'Diajukan Oleh,');
    doc.text(15,228,'PM/ Dept. Head');
    doc.text(15,244,x.dataTaf[8]);
    doc.text(15,248,'Tanggal :');
    
    doc.text(60,224,'Disetujui Oleh,');
    doc.text(60,228,'Related Div. Head/ Director');
    doc.text(60,244,x.dataTaf[9]);
    doc.text(60,248,'Tanggal :');
    
    doc.text(100,224,'Diperiksa Oleh,');
    doc.text(100,228,'Dept. Head');
    doc.text(100,244,x.dataTaf[10]);
    doc.text(100,248,'Tanggal :');
    
    doc.text(140,224,'Setuju / Tidak Setuju *),');
    doc.text(140,228,'Div. Head PEDD/ Director HR');
    doc.text(140,244,x.dataTaf[11]);
    doc.text(140,248,'Tanggal :');

    doc.text(15,263,'Catatan            :'); doc.text(50,263,'.............................................................................................................................................................................................................');
    doc.text(50,271,'.............................................................................................................................................................................................................');
    doc.text(15,276,'*) Coret yang tidak perlu.');
    doc.text(15,281,'**) Khusus u/ Pengajuan dari Jobsite harus melalui persetujuan Fungsional Dept Head/Direktur di Head Office');
    doc.text(180,285,'Revisi:1');
    
    doc.setLineWidth(0.3);
    doc.line(14, 245, 45, 245);
    doc.line(59, 245, 89, 245);
    doc.line(97, 245, 127, 245);
    doc.line(139, 245, 191, 245);
    doc.line(14, 255, 191, 255);
    
    
    doc.text( 'No.', 20, 98, 'center' );
    doc.text( 'NAMA', 45, 98, 'center' );
    doc.text( 'NRP', 78, 98, 'center' );
    doc.text( 'DEPARTMENT', 95, 98, 'center' );
    doc.text( 'JABTAN', 118, 98, 'center' );
    doc.text( '  MULAI\rBEKERJA', 140, 98, 'center' );

    doc.text( '    PARAF PERSETUJUAN\rATASAN FUNGSIONAL HO (DIV\r   HEAD / DEPT HEAD / SECT \r         HEAD)**)', 168, 95, 'center' );

    doc.setLineWidth(0.5);
    doc.line(15, 90, 190, 90);
    
    doc.line(15, 105, 190, 105);
    doc.line(15, 90, 15, 165);
    doc.line(25, 90, 25, 165);
    doc.line(190, 90, 190, 165);
    doc.line(150, 90, 150, 165);
    doc.line(130, 90, 130, 165);
    doc.line(105, 90, 105, 165);
    doc.line(85, 90, 85, 165);
    doc.line(70, 90, 70, 165);

    doc.setLineWidth(0.3);
    doc.line(15, 110, 190, 110);
    doc.line(15, 115, 190, 115);
    doc.line(15, 120, 190, 120);
    doc.line(15, 125, 190, 125);
    doc.line(15, 130, 190, 130);
    doc.line(15, 135, 190, 135);
    doc.line(15, 140, 190, 140);
    doc.line(15, 145, 190, 145);
    doc.line(15, 150, 190, 150);
    doc.line(15, 155, 190, 155);
    doc.line(15, 160, 190, 160);

    doc.setLineWidth(0.5);
    doc.line(15, 165, 190, 165);

    //------------Table content--------add line spacing 5// 
    var nama=id[0];
    var nrp=id[1];
    var sect=id[2];
    var jbt=id[3];
    var jndt=id[4];
    var cnt=nama.length;
    var init=108;

    for (var i=0;i<cnt;i++){
        var no=i+1;
        doc.text(19,init,no.toString()); doc.text(26,init,nama[i]); doc.text(72,init,nrp[i]); doc.text(95,init,sect[i],'center'); doc.text(118,init,jbt[i],'center'); doc.text(140,init,jndt[i],'center');
        init+=5;
    }
          

    doc.setFontSize(11);
    doc.setFontType("bold");
    doc.text(100, 30, 'TRAINING APPLICATION FORM (TAF)','center');
    doc.setLineWidth(0.5);
    doc.line(65, 31, 135, 31);
    img.onload = function () {
        doc.addImage(img, 'jpg', 15, 24, 27, 15);
        doc.save(namaTaf); 
    }
    // Save the PDF
}
