<!-- iconboxes -->
<div class="mil-p-0-100">
    <div class="container">
        <div class="row mil-jcc">

            @foreach($iconbox as $item)
                <div class="col-sm-8 col-lg-4">
                    <div class="mil-iconbox mil-tac mil-mb60">
                        <img src="{{ asset('uploads/' . $item->icon) }}" alt="icon" class="mil-mb30 mil-up">
                        <h4 class="mil-head4 mil-mb30 mil-up">{{$item->title}}</h4>
                        <p class="mil-text-md mil-shortened mil-up">{{$item->desc}}</p>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</div>

<!-- iconboxes end -->