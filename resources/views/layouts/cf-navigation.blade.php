<div class="row">
  <div class="col">
    <p class="text-muted" style="margin: 0.5em 0 0">Total {{ $entity_name }}: {{ $cars->total() }}</p>
  </div>
  <div class="col align-middle">
    {{ $collection->links() }}
  </div>
</div>
