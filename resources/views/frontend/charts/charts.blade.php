<div class="my-4 row">

    <div class="col-sm-6">
        <div class="card border-0" style="width: 26rem;">
            <div class="card-body">
              <h5 class="card-title">Deviation by classification</h5>
              
                <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100" id="deviationClassificationChart">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card border-0" style="width: 26rem;">
            <div class="card-body">
              <h5 class="card-title">Deviation by departments</h5>
              
                <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100" id="deviationDepartmentChart">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="my-4 row">
    <div class="col-sm-6">
        <div class="card border-0" style="width: 26rem;">
            <div class="card-body">
              <h5 class="card-title">Processes</h5>
              
                <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100" id="processChart">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
<h4>Documents Analytics</h4>

<div class="my-4 row">
  <div class="col-sm-6">
      <div class="card border-0" style="width: 26rem;">
          <div class="card-body">
            <h5 class="card-title">Document Type Distribution</h5>
            
              <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100" id="documentTypeDistribution">
                  <div class="spinner-border" role="status">
                      <span class="visually-hidden">Loading...</span>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-sm-6">
      <div class="card border-0" style="width: 26rem;">
          <div class="card-body">
            <h5 class="card-title">Review in Next 6 Months</h5>
            
              <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100" id="documentReviewSix">
                  <div class="spinner-border" role="status">
                      <span class="visually-hidden">Loading...</span>
                  </div>
              </div>
          </div>
      </div>
  </div>

</div>

<div class="my-4 row">

    <div class="col-sm-6">
        <div class="card border-0" style="width: 26rem;">
            <div class="card-body">
              <h5 class="card-title">Originator Distribution</h5>
              
                <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100" id="documentOriginatorDistribution">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card border-0" style="width: 26rem;">
            <div class="card-body">
              <h5 class="card-title">Documents by status</h5>
              
                <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100" id="documentCategoryChart">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js" integrity="sha512-JSCFHhKDilTRRXe9ak/FJ28dcpOJxzQaCd3Xg8MyF6XFjODhy/YMCM8HW0TFDckNHWUewW+kfvhin43hKtJxAw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>


    // Processes Charts start 
    function renderProcessChart(series, labels)
    {
        var options = {
            series,
            chart: {
            width: 350,
            type: 'pie',
            },
            labels,
            responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                width: 200
                },
                legend: {
                position: 'bottom'
                }
            }
            }]
        };

        var processChart = new ApexCharts(document.querySelector("#processChart"), options);
        processChart.render();
    }

    async function prepareProcessChart()
    {
        $('#processChart > .spinner-border').show();

        try {
            const url = "{{ route('api.process.chart') }}"
            const res = await axios.get(url);

            console.log('res', res.data)


            if (res.data.status == 'ok') {
                let bodyData = res.data.body;
                let series = []
                let labels = []

                for (const key in bodyData) {
                    labels.push(bodyData[key].classname)
                    series.push(bodyData[key].count)
                }

                renderProcessChart(series, labels)
            }

        } catch (err) {
            console.log('Error in process chart', err.message);
        }

        $('#processChart > .spinner-border').hide();
    }
    // Processes Charts End
    
    // Document by status Charts Starts
    function renderDocumentCategoryChart(series, labels)
    {
        var options = {
          series: [
                {
                    name: 'Documents',
                    data: series
                }
            ],
                chart: {
                type: 'bar',
                height: 350
                },
                plotOptions: {
                bar: {
                    distributed: true,
                    borderRadius: 4,
                    borderRadiusApplication: 'end',
                    horizontal: true,
                }
                },
                dataLabels: {
                enabled: false
                },
                xaxis: {
                categories: labels,
            }
        };

        var documentCategoryChart = new ApexCharts(document.querySelector("#documentCategoryChart"), options);
        documentCategoryChart.render();
    }

    async function prepareDocumentCategoryChart()
    {
        $('#documentCategoryChart > .spinner-border').show();

        try {
            const url = "{{ route('api.document_by_status.chart') }}"
            const res = await axios.get(url);

            console.log('res', res.data)


            if (res.data.status == 'ok') {
                let bodyData = res.data.body;
                let series = []
                let labels = []

                for (const key in bodyData) {
                    labels.push(key)
                    series.push(bodyData[key])
                }

                renderDocumentCategoryChart(series, labels)
            }

        } catch (err) {
            console.log('Error in process chart', err.message);
        }

        $('#documentCategoryChart > .spinner-border').hide();
    }
    // Document by status Charts End

    // Classification of deviation start
    function renderClassificationDeviationChart(minorData, majorData, criticalData, months)
    {
        var options = {
          series: [
            {
                name: 'Minor',
                data: minorData
            }, 
            {
                name: 'Major',
                data: majorData
            }, 
            {
                name: 'Critical',
                data: criticalData
            }
        ],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: months,
        },
        yaxis: {
          title: {
            text: '# of Deviations'
          }
        },
        fill: {
          opacity: 1,
          colors: ['#008FFB', '#FFBD00', '#FF2C00']
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " deviations"
            }
          }
        }
        };

        var deviationClassificationChart = new ApexCharts(document.querySelector("#deviationClassificationChart"), options);
        deviationClassificationChart.render();
    }

    async function prepareClassificationDeviationChart()
    {
        $('#deviationClassificationChart > .spinner-border').show();

        try {
            const url = "{{ route('api.deviation.chart') }}"
            const res = await axios.get(url);

            console.log('res', res.data)


            if (res.data.status == 'ok') {
                let bodyData = res.data.body;
                let minor = []
                let major = []
                let critical = []
                let labels = []

                for (const key in bodyData) {
                    labels.push(bodyData[key].month)
                    minor.push(bodyData[key].minor)
                    major.push(bodyData[key].major)
                    critical.push(bodyData[key].critical)
                }

                renderClassificationDeviationChart(minor, major, critical, labels)
            }

        } catch (err) {
            console.log('Error in deviation chart', err.message);
        }

        $('#deviationClassificationChart > .spinner-border').hide();
    }
    // Classification of deviation end
    
    // Departments wise deviation start
    function renderDeviationDepartmentChart(seriesData, labels)
    {
        var options = {
          series: seriesData,
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            distributed: true,
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: labels,
        },
        yaxis: {
          title: {
            text: '# of Deviations'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " deviations"
            }
          }
        }
        };

        var deviationDepartmentChart = new ApexCharts(document.querySelector("#deviationDepartmentChart"), options);
        deviationDepartmentChart.render();
    }

    async function prepareDeviationDepartmentChart()
    {
        $('#deviationDepartmentChart > .spinner-border').show();

        try {
            const url = "{{ route('api.deviation_departments.chart') }}"
            const res = await axios.get(url);

            console.log('res', res.data)


            if (res.data.status == 'ok') {
                let bodyData = res.data.body;
                let labels = []
                let seriesData = []

                for (const key in bodyData) {
                    labels.push(key)
                    seriesData[bodyData[key]['January']]
                }

                renderDeviationDepartmentChart(seriesData, labels)
            }

        } catch (err) {
            console.log('Error in deviation department chart', err.message);
        }

        $('#deviationDepartmentChart > .spinner-border').hide();
    }
    // Departments wise deviation end
    
    // Originator Distribution start
    function renderDocumentOriginatorChart(seriesData, labels)
    {
      var options = {
          series: [
          {
            name: 'Documents',
            data: seriesData
          }
        ],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            distributed: true,
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: labels,
        },
        yaxis: {
          title: {
            text: '# (documents)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " documents"
            }
          }
        }
        };

        var documentOriginatorDistribution = new ApexCharts(document.querySelector("#documentOriginatorDistribution"), options);
        documentOriginatorDistribution.render();
    }

    async function prepareDocumentOriginatorChart()
    {
        $('#documentOriginatorDistribution > .spinner-border').show();

        try {
            const url = "{{ route('api.document.originator.chart') }}"
            const res = await axios.get(url);

            console.log('res', res.data)


            if (res.data.status == 'ok') {
                let bodyData = res.data.body;
                let labels = []
                let seriesData = []

                for (const key in bodyData) {
                    labels.push(bodyData[key]['originator_name'])
                    seriesData.push(bodyData[key]['document_count'])
                }

                renderDocumentOriginatorChart(seriesData, labels)
            }

        } catch (err) {
            console.log('Error in document originator', err.message);
        }

        $('#documentOriginatorDistribution > .spinner-border').hide();
    }
    // Originator distribution end
    
    // Type Distribution start
    function renderDocumentTypeChart(seriesData, labels)
    {
      var options = {
          series: [
          {
            name: 'Documents',
            data: seriesData
          }
        ],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            distributed: true,
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: labels,
        },
        yaxis: {
          title: {
            text: '# (documents)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " documents"
            }
          }
        }
        };

        var documentTypeDistribution = new ApexCharts(document.querySelector("#documentTypeDistribution"), options);
        documentTypeDistribution.render();
    }

    async function prepareDocumentTypeChart()
    {
        $('#documentTypeDistribution > .spinner-border').show();

        try {
            const url = "{{ route('api.document.type.chart') }}"
            const res = await axios.get(url);

            console.log('res', res.data)


            if (res.data.status == 'ok') {
                let bodyData = res.data.body;
                let labels = []
                let seriesData = []

                for (const key in bodyData) {
                    labels.push(bodyData[key]['document_type_name'])
                    seriesData.push(bodyData[key]['document_count'])
                }

                renderDocumentTypeChart(seriesData, labels)
            }

        } catch (err) {
            console.log('Error in document originator', err.message);
        }

        $('#documentTypeDistribution > .spinner-border').hide();
    }
    // Type distribution end
    
    // Type Distribution start
    function renderDocumentSixChart(seriesData, labels)
    {
      var options = {
          series: [
          {
            name: 'Documents',
            data: seriesData
          }
        ],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            distributed: true,
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: labels,
        },
        yaxis: {
          title: {
            text: '# (documents)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " documents to be reviewed by this date"
            }
          }
        }
        };

        var documentReviewSix = new ApexCharts(document.querySelector("#documentReviewSix"), options);
        documentReviewSix.render();
    }

    async function prepareDocumentSixChart()
    {
        $('#documentReviewSix > .spinner-border').show();

        try {
            const url = "{{ route('api.document.review.chart', 6) }}"
            const res = await axios.get(url);

            console.log('res', res.data)


            if (res.data.status == 'ok') {
                let bodyData = res.data.body;
                let labels = []
                let seriesData = []

                bodyData.forEach(data => {
                    seriesData.push(1);
                    labels.push(data.next_review_date)
                });

                renderDocumentSixChart(seriesData, labels)
            }

        } catch (err) {
            console.log('Error in document originator', err.message);
        }

        $('#documentReviewSix > .spinner-border').hide();
    }
    // Type distribution end

    prepareProcessChart()
    prepareDocumentCategoryChart()
    prepareClassificationDeviationChart()
    prepareDeviationDepartmentChart()
    prepareDocumentOriginatorChart()
    prepareDocumentTypeChart()
    prepareDocumentSixChart()
      
</script>