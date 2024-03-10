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
              <h6 class="card-title">Mechanic Readiness</h6>
              <p>--</p>
              <canvas id="mechanicReadiness" style="max-height: 400px;"></canvas>
              <div id="spinnerDoughnatMr">
                <h5><span class="spinner-border text-primary"></span> Loading....</h5>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">Mech. Training Readiness</h6>
              <p>Knowledge</p>
              <!-- Donut Chart -->
              <canvas id="achTrainingReadiness" style="max-height: 400px;"></canvas>
              <div id="spinnerDoughnatTr">
                <h5><span class="spinner-border text-primary"></span> Loading....</h5>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">Mech. Competency Readiness</h6>
              <p>Skill</p>
              <!-- Donut Chart -->
              <canvas id="compReadinessChart" style="max-height: 400px;"></canvas>
              <div id="spinnerDoughnatComp">
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


    async function getAllMechanicReadiness(){
      try {
        let res =await getData('getAllReadiness')
        if(res.status !='ok'){
          console.log(res)
        }else{
          let dd=res.data;
          chartMechanicReadiness(dd.mR);
          chartTrainingReadiness(dd.tr);
          chartCompReadiness(dd.comp);
          let spin1=document.getElementById('spinnerDoughnatMr');
          let spin2=document.getElementById('spinnerDoughnatTr');
          let spin3=document.getElementById('spinnerDoughnatComp');
          spin1.innerHTML='';
          spin2.innerHTML='';
          spin3.innerHTML='';
          
        }
      } catch (err) {
        
      }
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
          // console.log(aa);
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
        // console.log(res);
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



    function chartMechanicReadiness(d){    
      const data = {
        labels: [
          `Readiness: ${d}%`
        ],
        datasets: [{
          // label:d.jml,
          data: [d,(100-d)],
          borderWidth: 1,
          backgroundColor: ['#6273f5','#e6e7ed']
     
          
        }]
      };

      let chart = new Chart(document.getElementById('mechanicReadiness'),
      {
        type: 'doughnut',
        data: data,        
      })
    }


    function chartTrainingReadiness(d){    
      const data = {
        labels: [
          `Close: ${d.closePer}%`,
          `Open: ${d.openPer}%`
        ],
        datasets: [{
          // label:d.jml,
          data: [d.close,d.open],
          borderWidth: 1,
          backgroundColor: ['#6273f5','#f2aeae']
        }]
      };


      let chart = new Chart(document.getElementById('achTrainingReadiness'),
      {
        type: 'doughnut',
        data: data,
      })
    }


    function chartCompReadiness(d){    
      const data = {
        labels: [
          `Close: ${d.closePer}%`,
          `Open: ${d.openPer}%`
        ],
        datasets: [{
          // label:d.jml,
          data: [d.close,d.open],
          borderWidth: 1,
          backgroundColor: ['#6273f5','#f2aeae']
        }]
      };


      let chart = new Chart(document.getElementById('compReadinessChart'),
      {
        type: 'doughnut',
        data: data,
      })
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
            },
          }
        },
        plugins:[ChartDataLabels]
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
            },
            
          },
          plugins:{
            datalabels:{
              
            },
            legend:{
              display:false
            },
            tooltip:{
              enabled:true
            },
          }
        },

        plugins:[ChartDataLabels]

      })
    }

    // //-----------------------------------------------------------------------//
    $(document).ready( function(){
      levelMechanicChart();
      gradeMachanicChart();
      getAllMechanicReadiness();
      });    
   
  </script>
@endpush

  