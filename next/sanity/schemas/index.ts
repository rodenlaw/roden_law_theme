import practiceArea from "./practiceArea";
import location from "./location";
import attorney from "./attorney";
import caseResult from "./caseResult";
import testimonial from "./testimonial";
import resource from "./resource";
import blogPost from "./blogPost";
import practiceCategory from "./practiceCategory";
import locationServed from "./locationServed";
import faq from "./objects/faq";
import education from "./objects/education";
import award from "./objects/award";

export const schemaTypes = [
  // Documents
  practiceArea,
  location,
  attorney,
  caseResult,
  testimonial,
  resource,
  blogPost,
  // Taxonomies
  practiceCategory,
  locationServed,
  // Objects
  faq,
  education,
  award,
];
