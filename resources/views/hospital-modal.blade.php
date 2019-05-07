<div class="modal fade" id="hospitalDetailsModal" tabindex="-1" role="dialog" aria-labelledby="hospitalModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
      <div class="card-header text-center">
          <h4 class="title">{{ucfirst(session('hospital')->name)}}</h4>
          <h5 class="subtitle text-lighted">{{ucfirst(session('hospital')->address)}}</h5>
          <h5 class="subtitle text-lighted">{{ucfirst(session('hospital')->district->name)}}</h5>
          <h5 class="subtitle text-lighted">{{ucfirst(session('hospital')->contact_number)}}</h5>
      </div>
      <div class="modal-footer text-center">
        <span style="font-size: 11px"><i>Contact regional biomedical engineer to rectify any wrong information.</i></span>
      </div>
    </div>
  </div>
</div>
