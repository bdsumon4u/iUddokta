@extends('layouts.yellow.master')

@section('content')
<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
  background-color: #34495e;
  color: #fff;
}
h1 {
  text-align: center;
  margin: 2rem 0;
  font-size: 2.5rem;
}

.accordion {
  width: 90%;
  max-width: 1000px;
  margin: 2rem auto;
}
.accordion-item {
  background-color: #fff;
  color: #111;
  margin: 1rem 0;
  border-radius: 0.5rem;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.25);
}
.accordion-item-header {
  padding: 0.5rem 3rem 0.5rem 1rem;
  min-height: 3.5rem;
  line-height: 1.25rem;
  font-weight: bold;
  display: flex;
  align-items: center;
  position: relative;
  cursor: pointer;
}
.accordion-item-header::after {
  content: "\002B";
  font-size: 2rem;
  position: absolute;
  right: 1rem;
}
.accordion-item-header.active::after {
  content: "\2212";
}
.accordion-item-body {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
.accordion-item-body-content {
  padding: 1rem 1.5rem;
  line-height: 1.5rem;
  border-top: 1px solid;
  border-image: linear-gradient(to right, transparent, #34495e, transparent) 1;
}

@media (max-width: 767px) {
  html {
    font-size: 14px;
  }
}
</style>
<h1>FAQ'S</h1>

<div class="accordion">
    @foreach($faqs as $faq)
  <div class="accordion-item">
    <div class="accordion-item-header">
      {{ $faq->question }}
    </div>
    <div class="accordion-item-body">
      <div class="accordion-item-body-content">
        {!! $faq->answer !!}
      </div>
    </div>
  </div>
  @endforeach
</div>
<script>
    const accordionItemHeaders = document.querySelectorAll(
  ".accordion-item-header"
);

accordionItemHeaders.forEach((accordionItemHeader) => {
  accordionItemHeader.addEventListener("click", (event) => {
    // Uncomment in case you only want to allow for the display of only one collapsed item at a time!

    const currentlyActiveAccordionItemHeader = document.querySelector(
      ".accordion-item-header.active"
    );
    if (
      currentlyActiveAccordionItemHeader &&
      currentlyActiveAccordionItemHeader !== accordionItemHeader
    ) {
      currentlyActiveAccordionItemHeader.classList.toggle("active");
      currentlyActiveAccordionItemHeader.nextElementSibling.style.maxHeight = 0;
    }
    accordionItemHeader.classList.toggle("active");
    const accordionItemBody = accordionItemHeader.nextElementSibling;
    if (accordionItemHeader.classList.contains("active")) {
      accordionItemBody.style.maxHeight = accordionItemBody.scrollHeight + "px";
    } else {
      accordionItemBody.style.maxHeight = 0;
    }
  });
});
</script>
@endsection

@section('contentx')
<div id="accordion">
    @foreach($faqs as $faq)
    <div class="card">
        <div class="card-header" id="heading-{{ $faq->id }}">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-{{ $faq->id }}"
                    aria-expanded="true" aria-controls="collapse-{{ $faq->id }}">
                    {{ $faq->question }}
                </button>
            </h5>
        </div>

        <div id="collapse-{{ $faq->id }}" class="collapse" aria-labelledby="heading-{{ $faq->id }}"
            data-parent="#accordion">
            <div class="card-body text-left">{!! $faq->answer !!}</div>
        </div>
    </div>
    @endforeach
</div>
@endsection