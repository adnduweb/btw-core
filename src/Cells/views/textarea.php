<div class="" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
  <textarea
    name="body"
    class="char-limiter"
    rows="3"
    maxlength="280"
    x-ref="countme"
    x-on:keyup="count = $refs.countme.value.length"
  ></textarea>

  <div class="">
    <span x-html="count"></span> /
    <span x-html="$refs.countme.maxLength"></span>
  </div>
</div>