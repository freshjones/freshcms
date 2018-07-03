# freshcms
Laravel Content Management System Demo

**Demo** 
https://cms.freshjones.com/


**Login**  
https://cms.freshjones.com/login

**Username**  
admin@freshjones.com

**Password**  
welcome


Laravel 5.6 content management system proof of concept with Vue.js administrative features.

Highlights:

[Simple Vue Data Store for sharing data between components](https://github.com/freshjones/freshcms/blob/18bc721e5f7e778d2283012fda315bf1f2164cbe/resources/assets/js/app.js#L5)

[Placeholder content while data loads via axios](https://github.com/freshjones/freshcms/blob/18bc721e5f7e778d2283012fda315bf1f2164cbe/resources/assets/js/components/sections/SectionsComponent.vue#L3)

[Dynamically sort and save content via axios](https://github.com/freshjones/freshcms/blob/18bc721e5f7e778d2283012fda315bf1f2164cbe/resources/assets/js/components/sections/SectionsComponent.vue#L66)

[Simple Concrete Controllers](https://github.com/freshjones/freshcms/blob/4a94f9e4fb9114a83c6767884de3e0c1619c1d80/app/Http/Controllers/Content/BillboardController.php#L12)

[Abstract Controllers with Repo and Helper Services](https://github.com/freshjones/freshcms/blob/bf27c519b25b6b870614ac8d855d0c7ddd9c23d4/app/Http/Controllers/Content/BaseContentController.php#L14)

[Reusable Traits](https://github.com/freshjones/freshcms/blob/d999f4b811b61848d5a5a75e15ada0caf8f50d7d/app/Traits/RendersPageView.php#L7)

[Repository Pattern with Contracts](https://github.com/freshjones/freshcms/blob/8d0fa2987c92f554004ffbf8e176a0ff72f71f92/app/Repositories/Contracts/PageRepositoryInterface.php#L4)

[Models with Relationships and KeyBinding Override](https://github.com/freshjones/freshcms/blob/b9d0627cd2560ed322f0cfe70fb75068b5e12866/app/Page.php#L5)


