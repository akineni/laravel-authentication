@include('_partials.head')

  <body>

    <div class="content-wrapper">
        <!-- Content -->
        <div class="container flex-grow-1 container-p-y">

            @if(session('class'))
                <div class="alert alert-{{ session('class') }}" role="alert">{!! session('message') !!}</div>
            @else                  
                <h3 class="fw-bold p-4">Verify your email address</h3>

                <p>To proceed kindly click the email verification link in the email sent to you.</p> 

                <p>If you did not receive the verification email kindly click the button below</p> 
                <form method="POST" action="{{ url('email/verification-notification') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Resend verification link</button>
                </form>
            
            @endif

        </div>

    <!-- / Content -->
    </div>
    <!-- Content wrapper -->

    @include('_partials.tail')
  </body>
</html>
