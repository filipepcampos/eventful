<!-- Accessibility -->
<div class="mb-2">
<span class="card-text">
    <i class="bi bi-box-arrow-up" style="font-size: 1.5rem"></i>
    {{ $event->is_accessible ? 'Public' : 'Private' }}
</span>
</div>
<!-- Date -->
<div class="mb-2">
<span class="card-text">
    <i class="bi bi-calendar-check" style="font-size: 1.5rem"></i>
    {{ $event->realization_date }}
</span>
</div>
<!-- Location -->
<div class="mb-2">
<span class="card-text">
    <i class="bi bi-compass" style="font-size: 1.5rem"></i>
    {{ $event->location }}
</span>
</div>
<!-- Price -->
<div>
<span class="card-text">
    <i class="bi bi-tag" style="font-size: 1.5rem"></i>
    {{ $event->price == 0.00 ? 'Free' : $event->price . '€' }}
</span>
</div>
<!-- Capacity -->
<div>
<span class="card-text">
    <i class="bi bi-person" style="font-size: 1.5rem"></i>
    {{ $event->number_attendees . '/' . $event->capacity }}
</span>
</div>