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

**Highlights** 

[Simple Vue Data Store for sharing data between components](https://github.com/freshjones/freshcms/blob/18bc721e5f7e778d2283012fda315bf1f2164cbe/resources/assets/js/app.js#L5)

[Placeholder Content While Data Loads Via Axios](https://github.com/freshjones/freshcms/blob/18bc721e5f7e778d2283012fda315bf1f2164cbe/resources/assets/js/components/sections/SectionsComponent.vue#L3)

[Dynamically Sort and Save Content Via Axios](https://github.com/freshjones/freshcms/blob/18bc721e5f7e778d2283012fda315bf1f2164cbe/resources/assets/js/components/sections/SectionsComponent.vue#L66)

[Simple Concrete Controllers](https://github.com/freshjones/freshcms/blob/4a94f9e4fb9114a83c6767884de3e0c1619c1d80/app/Http/Controllers/Content/BillboardController.php#L12)

[Abstract Controllers with Repo and Helper Services](https://github.com/freshjones/freshcms/blob/bf27c519b25b6b870614ac8d855d0c7ddd9c23d4/app/Http/Controllers/Content/BaseContentController.php#L14)

[Reusable Traits](https://github.com/freshjones/freshcms/blob/d999f4b811b61848d5a5a75e15ada0caf8f50d7d/app/Traits/RendersPageView.php#L7)

[Repository Pattern with Contracts](https://github.com/freshjones/freshcms/blob/8d0fa2987c92f554004ffbf8e176a0ff72f71f92/app/Repositories/Contracts/PageRepositoryInterface.php#L4)

[Models with Relationships and KeyName Override](https://github.com/freshjones/freshcms/blob/b9d0627cd2560ed322f0cfe70fb75068b5e12866/app/Page.php#L5)

[Service hHelper Classes with Laravel Collections](https://github.com/freshjones/freshcms/blob/0739b8a979ff407ab3d7861359a80e1a4f0e04f7/app/Services/Sections/SectionService.php#L7)

[Extended Views with Bootstrap Theming](https://github.com/freshjones/freshcms/blob/ed308587bbe2ccce0f56632197054e4474641d9b/resources/views/admin/section/content/edit.blade.php#L1)

[Unit Testing](https://github.com/freshjones/freshcms/blob/55c8c6003486a35fb1f486172b1bb98e2463385a/tests/Unit/PageControllerTest.php#L10)
