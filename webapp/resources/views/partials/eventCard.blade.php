<div class="col-auto mb-5">
    <div class="card h-100">
      <img class="card-img-top" src='{{ url("/image/event/$event->id") }}' alt="Event image">
      <div class="card-body">
        <h5 class="card-title">{{ $event->title }}</h5>
        <p class="card-text">{{ $event->description }}</p>
      </div>
      <div class="card-footer">
        <a href="/event/{{ $event->id }}" class="btn btn-primary ml-auto">Go somewhere</a>
      </div>
    </div>
</div>