import sys
import json
from datetime import datetime
import datetime

# {|verification_year|: |2024|, |org_title|: |ФБУ ^ПРИОКСКИЙ ЦСМ^|, |mi.mititle|: |Уровнемеры радиоволновые|, |mi.mitnumber|: |16861-08|, |mi.mitype|: |улм|, |mi.modification|: |УЛМ-31А1|,|verification_date|: |[2024-09-10T00:00:00Z TO 2024-09-11T23:59:59Z]|}

def makeMainLink(arguments,rows):
    filters = arguments
    filters = filters.replace('|', '"')
    # https://fgis.gost.ru/fundmetrology/cm/xcdb/vri/select?fq=verification_year:2024&fq=org_title:*1*&fq=mi.mitnumber:*2*&fq=mi.mititle:*3*&fq=mi.mitype:*4*&fq=mi.modification:*5*&fq=verification_date:[2024-09-05T00:00:00Z%20TO%202024-09-20T23:59:59Z]&q=*&fl=vri_id,org_title,mi.mitnumber,mi.mititle,mi.mitype,mi.modification,mi.number,verification_date,valid_date,applicability,result_docnum,sticker_num&sort=verification_date+desc,org_title+asc&rows=20&start=0
    reqHead = 'https://fgis.gost.ru/fundmetrology/cm/xcdb/vri/select?'
    reqTail = 'q=*&fl=vri_id,org_title,mi.mitnumber,mi.mititle,mi.mitype,mi.modification,mi.number,verification_date,valid_date,applicability,result_docnum,sticker_num&sort=verification_date+desc,org_title+asc&rows=' + str(rows) #вырезан &start=0
    filtersDict = json.loads(filters)

    reqBody = ''

    if filtersDict["verification_year"] != "":
        reqBody = reqBody + "fq=verification_year:" + filtersDict["verification_year"] + "&"

    for filter in filtersDict:
        if filtersDict[filter] == "" or filter == "verification_year":
            continue
        if filter != "verification_date":
            curentFilterValue = filtersDict[filter]
            curentFilterValue = curentFilterValue.replace('^', '\\"')
            curentFilterValue = curentFilterValue.replace('-', '\\-')
            singleWords = curentFilterValue.split()
            for word in singleWords:
                reqBody = reqBody + "fq=" + filter + ":*" + word + "*&"
        else:
            reqBody = reqBody + "fq=" + filter + ":" + filtersDict[
                filter] + "&"  # диапазон дат вставляется без * по бокам

    fullReq = reqHead + reqBody + reqTail
    return fullReq

def makeFileName(arguments):
    badSymbols = {ord('+') : None, ord('=') : None, ord('.') : None, ord('[') : None, ord(':') : None, ord(']') : None, ord('*') : None, ord('?') : None, ord(';') : None, ord('.') : None, ord('|') : None, ord('\\') : None, ord('/') : None}
    filters = arguments
    filters = filters.replace('|', '"')
    filtersDict = json.loads(filters)
    fn = ''

    if (filtersDict["mi.mititle"]):
        fn = fn + filtersDict["mi.mititle"] + '_'
    if (filtersDict["mi.mitnumber"]):
        fn = fn + filtersDict["mi.mitnumber"] + '_'
    if (filtersDict["mi.mitype"]):
        fn = fn + filtersDict["mi.mitype"] + '_'
    if (filtersDict["mi.modification"]):
        fn = fn + filtersDict["mi.modification"] + '_'
    if (filtersDict["org_title"]):
        fn = fn + filtersDict["org_title"] + '_'

    fn = fn.translate(badSymbols)
    fn = fn.replace('^','\"')
    fn = fn + "_" + dateplustime() + ".xlsx"

    return fn



def dateplustime():
    dt = datetime.datetime.now()
    date1st = dt.strftime('%d-%m-%Y')
    date2nd = dt.strftime('-%H-%M')
    return date1st + date2nd

def main():
    lnk = makeMainLink(sys.argv[1],9000) + '&start=0'
    makeFileName(sys.argv[1])

    #print(lnk)






if __name__ == "__main__":
    main()