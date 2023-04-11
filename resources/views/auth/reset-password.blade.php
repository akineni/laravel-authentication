@include('_partials.head')

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
              
              <h4 class="mb-2">Reset your password 🚀</h4>
              <p class="mb-4"></p>

              @if(session('status'))
                <div class="alert alert-{{ session('class') }}" role="alert">{!! session('status') !!}</div>
              @endif

              <form id="formAuthentication" class="mb-3" method="POST" autocomplete="off"
              action="{{ url('reset-password') }}">
                @csrf

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email"
                  placeholder="Enter your email" value="{{ old('email') }}" autofocus />

                  @error('email')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror

                </div>
                
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>

                  @error('password')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror

                </div>

                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password_confirmation">Password Confirmation</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password_confirmation"
                      class="form-control"
                      name="password_confirmation"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password_confirmation"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>

                  @error('password_confirmation')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror

                </div>
                <input type="hidden" name="token" value="{{ $token }}" />
                <button class="btn btn-primary d-grid w-100">Reset Password</button>
              </form>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->
    @include('_partials.tail')
  </body>
</html>
