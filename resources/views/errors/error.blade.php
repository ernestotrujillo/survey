@if (session()->has('message'))
    <?php
        $message = session('message');
        if(isset($message['type']))
        {
            switch ($message['type']) {
                case 'error':
                    $class = 'alert-danger';
                    break;
                case 'success':
                    $class = 'alert-success';
                    break;
                default:
                    $class = 'alert-info';
            }
     ?>
        <div class="alert {{ $class }}">
            {{ $message['message'] }}
        </div>
    <?php } ?>
@endif