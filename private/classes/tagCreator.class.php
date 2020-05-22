<?php
    //Class is used to create various subClasses of Source
    class TagCreator
    {
       static public function getTags($tagType, $srcType, $srcId)
        {
            switch($tagType)
            {
                case "culture":
                    return CultureTag::findTags($srcType, $srcId);
                break;
                case "discipline":
                    return DisciplineTag::findTags($srcType, $srcId);
                break; 
                case "area":
                    return AreaTag::findTags($srcType, $srcId);
                break;
                case "time period":
                    return TimePeriodTag::findTags($srcType, $srcId);
                break;
                case "theoretical topic":
                    return TheoreticalTopicTag::findTags($srcType, $srcId);
                break;
                case "skeletal collection":
                    return SkeletalCollectionTag::findTags($srcType, $srcId);
                break;
                default:
                return false;
            }

        }
    }
?>