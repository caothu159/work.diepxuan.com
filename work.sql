SELECT txt.TEXT AS [SQL Statement],
    qs.EXECUTION_COUNT [No. Times Executed],
    qs.LAST_EXECUTION_TIME AS [Last Time Executed],
    DB_NAME(txt.dbid) AS [Database]
FROM SYS.DM_EXEC_QUERY_STATS AS qs
    CROSS APPLY SYS.DM_EXEC_SQL_TEXT(qs.SQL_HANDLE) AS txt
WHERE txt.dbid = DB_ID('diepxuan')
ORDER BY qs.LAST_EXECUTION_TIME DESC;
-- AsiaSoft, Oct 20 2008  8:08AM
-- Created by LocPv
-- Cap nhat lai so lieu cho cac doi tuong lien quan toi PO3 (hoa don)
CREATE PROCEDURE [dbo].[asReCalPO34Relate] @pMa_cty nvarchar(3),
@pStt_rec nvarchar(20) AS -- cap nhat lai so luong da viet hoa don
declare @stt_rec_pn nvarchar(20)
declare stt_rec_pn cursor for
select stt_rec_pn
from poct3
where ma_cty = @pma_cty
    and stt_rec = @pStt_rec
    and stt_rec_pn <> ''
group by stt_rec_pn open stt_rec_pn fetch next
from stt_rec_pn into @stt_rec_pn while @@fetch_status = 0 begin exec asReCalPO2 @pMa_cty,
    @stt_rec_pn -- tinh lai so lieu cho cac phieu nhap lien quan
    fetch next
from stt_rec_pn into @stt_rec_pn
end close stt_rec_pn deallocate stt_rec_pn -- cap nhat lai so luong da nhap kho cua cac don dat hang voi nha cung cap
declare @stt_rec_dh nvarchar(20),
    @ma_gd nvarchar(1)
declare stt_rec_dh cursor for
select stt_rec_dh
from poct3
where ma_cty = @pma_cty
    and stt_rec = @pStt_rec
    and stt_rec_dh <> ''
group by stt_rec_dh open stt_rec_dh fetch next
from stt_rec_dh into @stt_rec_dh while @@fetch_status = 0 begin exec asReCalPO1 @pMa_cty,
    @stt_rec_dh -- tinh lai so lieu cho cac don hang lien quan
    fetch next
from stt_rec_dh into @stt_rec_dh
select @stt_rec_dh
end close stt_rec_dh deallocate stt_rec_dh -- Tinh lai so du tuc thoi
declare @nam int
declare @ma_kh nvarchar(20)
select @nam = year(ngay_ct),
    @ma_kh = ma_kh
from poph3
where ma_cty = @pMa_cty
    and stt_rec = @pStt_rec exec asArRecalCustBalance @pMa_cty,
    @ma_kh,
    @nam
