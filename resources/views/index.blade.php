@extends('layouts/main')
@section ('container')
    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Mechanic <span>| Today</span></h5>

                  <div class="d-flex align-items-center">
                    <a href="/somplak?mode=MECHANIC">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    </a>
                    <div class="ps-3">
                      <h6>{{$qtyMechanic}}</h6>
                      {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Field Support<span>| Today</span></h5>

                  <div class="d-flex align-items-center">
                    <a href="/somplak?mode=FIELD SUPPORT">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    </a>
                    <div class="ps-3">
                      <h6>{{$qtyTireman}}</h6>
                      {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Group Leader Setara <span>| Today</span></h5>

                  <div class="d-flex align-items-center">
                    <a href="/somplak?mode=GROUP LEADER">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    </a>
                    <div class="ps-3">
                      <h6>{{$qtyGroupLeader}}</h6>
                      {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-md-6">

              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Labour Supply <span>| Today</span></h5>

                  <div class="d-flex align-items-center">
                    <a href="/somplak?mode=LABOUR SUPPLY">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    </a>
                    <div class="ps-3">
                      <h6>{{$qtyLabourSupply}}</h6>
                      {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->        

          </div>
        </div><!-- End Left side columns -->

      </div>
        
    </section>

    <section>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Mechanic Grade Compositon</h5>
              <!-- Donut Chart -->
              <canvas id="gradeMechanicChart" style="max-height: 400px;"></canvas>
              {{-- <div>
                <h5><span class="spinner-border text-primary"></span> Loading....</h5>
              </div> --}}
            </div>
          </div>
        </div>
      </div>   
    </section>
    <section>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Mechanic Spcl Compositon</h5>
              <!-- Donut Chart -->
              <canvas id="spclMechanicComposition" style="max-height: 400px;"></canvas>
              {{-- <div>
                <h5><span class="spinner-border text-primary"></span> Loading....</h5>
              </div> --}}
            </div>
          </div>
        </div>
      </div>   
    </section>

    <section>
      <div class="row">
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Mechanic Training Readiness</h5>
              <!-- Donut Chart -->
              <canvas id="achReadiness" style="max-height: 400px;"></canvas>
              <div>
                <h5><span class="spinner-border text-primary"></span> Loading....</h5>
              </div>
            </div>
          </div>
        </div>
      </div>   
    </section>

    @endsection

@push('scripts')
  <script>
    const achReadinessChart=document.getElementById('achReadiness');
    const achAllReadinessChartConfig={
      type: 'doughnut',
      data: {
              labels: [
                        `Close: loading...`,
                        `Open: loading...`
                      ],
              datasets: [{
                          label: 'Readiness Training',
                          data: [0, 100],
                          backgroundColor: [
                            'rgb(230, 230, 230)',
                            'rgb(230, 230, 230)'  
                          ],
                          hoverOffset: 4
                        }]
            },
      setting:function(x,y){
              let pOpen=(x/(x+y)*100).toFixed(2);
              let pClose=(y/(x+y)*100).toFixed(2);
              this.data.labels=[
                `Close: ${pClose} %`,
                `Open: ${pOpen} %`
              ];
              this.data.datasets=[
                {
                  label: 'Readiness Training',
                  data: [y, x],
                  backgroundColor: [
                            'rgb(54, 162, 235)',
                            'rgb(237, 50, 55)'  
                          ],
                  hoverOffset: 4
                }
              ]
              }
    }

    const achReadinessTrainingChart=new Chart(achReadinessChart,achAllReadinessChartConfig);

    const readinessTraining={
      ach:function(){
          let open=0;
          let close=0;
          let ach=0;
          // console.log(this.filter.length);
          this.allData.forEach(dd => {
            let hitung=false;
            if(this.filter.length>0){
              this.filter.forEach(ff => {
                if(dd[ff.filter]===ff.value){
                  hitung=true;
                }else{
                  hitung=false;
                }
              });
            }else{
              hitung=true;
            }

            if(hitung===true){
              close+=dd.close;
              open+=dd.open;
            }
          });
          ach=(close/(open+close)*100).toFixed(2);
          return {
            open:open,
            close:close,
            ach:ach
          }
          },
      filter:[],
      allData:[],
    }

    function updateChartAchReadiness(x,y){
      achAllReadinessChartConfig.setting(x,y);
      achReadinessTrainingChart.update();
    }


    // function AchReadinessTrainingClick(click){
    //   const points = achReadinessTrainingChart.getElementsAtEventForMode(click, 'nearest', { intersect: true }, true);
    //   // console.log(points[0].index);
    //   achReadinessTrainingChart.toggleDataVisibility(points[0].index); // hides dataset at index 1
    //   achReadinessTrainingChart.update(); // chart now renders with dataset hidden
    // }
    
    function getData(d){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      return $.ajax({
        type: 'GET',
        data:{data:d},
        url:'/dataDashboard',})
    }
    async function gradeMachanicChart(){
      try {
        let res =await getData('spclComposition')
        if(res.status !='ok'){
          console.log(res)
        }else{
          dataJadi={
            spcl:[],
            jmlh:[]
          }
          aa=res.data;
          console.log(aa);
          aa.forEach(eAa => {
            dataJadi.spcl.push(eAa.spcl);
            dataJadi.jmlh.push(eAa.jmlh);
          });
          chartSpcl(dataJadi);
        }
      } catch (err) {
        
      }
    }
    async function levelMechanicChart(){
      try {
        let res=await getData('levelMechanicAllChart');
        console.log(res);
        if(res.status !='ok'){
          console.log('error data');
        }else{
          dataJadi={
            grade:[],
            jml:[],
          };
          q=res.data;
          q.forEach(eq => {
            dataJadi.grade.push(eq.grade);
            dataJadi.jml.push(eq.jumlah)
          });
          chartLevel(dataJadi);
        }
      } catch (err) {
        console.log(err);
      }

    }



    function chartSpcl(d){    
      const data = {
        labels: d.spcl,
        datasets: [{
          // label:d.jml,
          data: d.jmlh,
          borderWidth: 1
        }]
      };
      let chart = new Chart(document.getElementById('spclMechanicComposition'),
      {
        
        type: 'bar',
        data: data,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
            
          },
          plugins:{
      
              legend:{
                display:false
              },
              tooltip:{
                enabled:true
              }
            
          }
        }
      })
    }

    
    function chartLevel(d){      
      const data = {
        labels: d.grade,
        datasets: [{
          // label:d.jml,
          data: d.jml,
          borderWidth: 1
        }]
      };
      let chart = new Chart(document.getElementById('gradeMechanicChart'),
      {
        
        type: 'bar',
        data: data,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
            
          },
          plugins:{
      
              legend:{
                display:false
              },
              tooltip:{
                enabled:true
              }
            
          }
        }
      })
    }

    // //-----------------------------------------------------------------------//
    $(document).ready( function(){
      levelMechanicChart();
      gradeMachanicChart();
      getDataAchReadinessTraining();
      // achReadinessChart.onclick=AchReadinessTrainingClick;
      });    
   
    async function getDataAchReadinessTraining(){
       try {
         
       let data=await     $.ajax({
            type: 'GET',
            url:'/api/trainingReadiness',

            });
        data=JSON.parse(data);
        // console.log(data);
        readinessTraining.allData=data;
        readinessTraining.filter=[]
        let a=readinessTraining.ach();
        let sp=achReadinessChart.nextElementSibling;
        sp.style.display='none';
       updateChartAchReadiness(a.open,a.close);
       } catch (error) {
        console.log(error);
    }
   }
  </script>
@endpush

  